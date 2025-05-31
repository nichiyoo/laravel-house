<?php

namespace App\Http\Controllers\Tenants;

use App\Enums\MethodType;
use App\Enums\StatusType;
use App\Enums\VerificationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRentRequest;
use App\Models\Property;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PropertyController extends Controller
{
  public function __construct(private NotificationService $notification)
  {
    Gate::define('check', function (User $user, Property $property) {
      return $property->verification === VerificationType::VERIFIED;
    });
  }

  /**
   * Function to authorize the property.
   */
  private function check(Property $property): void
  {
    $deny = Gate::denies('check', $property);
    if ($deny) abort(404, 'Property not found');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $keyword = $request->get('query');
    $min = $request->get('price_min');
    $max = $request->get('price_max');
    $rating = $request->get('rating');
    $distance = $request->get('distance');
    $interval = $request->get('interval');

    $properties = Property::with('owner')->verified()
      ->when($keyword, function ($query) use ($keyword) {
        return $query->where(function ($q) use ($keyword) {
          $q->where('name', 'like', '%' . $keyword . '%')
            ->orWhere('city', 'like', '%' . $keyword . '%')
            ->orWhere('region', 'like', '%' . $keyword . '%')
            ->orWhere('address', 'like', '%' . $keyword . '%')
            ->orWhere('zipcode', 'like', '%' . $keyword . '%');
        });
      })
      ->when($min && $max, function ($query) use ($min, $max) {
        return $query->whereBetween('price', [
          $min,
          $max
        ]);
      })
      ->when($interval, function ($query) use ($interval) {
        return $query->where('interval', $interval);
      })
      ->get();

    if ($rating) $properties = $properties->where('rating', '>=', $rating);
    if ($distance) $properties = $properties->where('distance', '<=', $distance);

    return view('tenants.properties.index', [
      'properties' => $properties,
    ]);
  }


  /**
   * Display the specified resource.
   */
  public function show(Property $property): View
  {
    $this->check($property);

    return view('tenants.properties.show', [
      'property' => $property->load('owner'),
    ]);
  }

  /**
   * Display the reviews of the specified resource.
   */
  public function reviews(Property $property): View
  {
    $this->check($property);

    return view('tenants.properties.reviews', [
      'property' => $property->load('owner'),
      'reviews' => $property->tenants()->with('user')
        ->wherePivot('is_reviewed', true)
        ->get(),
    ]);
  }

  /**
   * Display the location of the specified resource.
   */
  public function location(Property $property): View
  {
    $this->check($property);

    return view('tenants.properties.location', [
      'property' => $property->load('owner'),
    ]);
  }

  /**
   * Bookmark the specified resource.
   */
  public function bookmark(Property $property): RedirectResponse
  {
    $this->check($property);

    $tenant = Auth::user()->tenant;
    $tenant->bookmarks()->toggle($property);
    $bookmarked = $tenant->bookmarks->contains($property);

    return redirect()->back()
      ->with('success', $bookmarked ? 'Property bookmarked successfully' : 'Property removed from bookmarks');
  }

  /**
   * Display the virtual tour of the specified resource.
   */
  public function tour(Property $property): RedirectResponse
  {
    $this->check($property);

    $images = $property->images;
    if (!$images) return redirect()->back()->with('error', 'Property has no images');

    return redirect()->route('tenants.properties.room', [
      'property' => $property,
      'room' => 1,
    ]);
  }

  /**
   * Display the virtual tour of the specified resource.
   */
  public function room(Property $property, int $room): View|RedirectResponse
  {
    $this->check($property);

    $images = $property->images;
    if (!$images) return redirect()->back()->with('error', 'Property has no images');

    $room = $room % count($images);
    $images = array_map(fn($image) => asset($image), $images);

    return view('tenants.properties.tour', [
      'property' => $property,
      'room' => $images[$room],
      'images' => $images,
    ]);
  }

  /**
   * Display the rent form of the specified resource.
   */
  public function rent(Property $property): View|RedirectResponse
  {
    $this->check($property);
    if ($property->capacity <= 0) return redirect()->back()->with('error', 'Property is fully booked');

    return view('tenants.properties.rent', [
      'property' => $property->load('owner'),
      'methods' => MethodType::cases(),
      'statuses' => StatusType::cases(),
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreRentRequest $request, Property $property): RedirectResponse
  {
    $this->check($property);

    $validated = $request->validated();
    $tenant = Auth::user()->tenant;
    if ($property->capacity <= 0) return redirect()->back()->with('error', 'Property is fully booked');

    DB::beginTransaction();
    $tenant->rented()->attach($property->id, [
      ...$validated,
      'review' => 'No review yet',
      'status' => StatusType::PENDING,
    ]);
    $property->capacity = max(0, $property->capacity - 1);
    $property->save();
    DB::commit();

    $this->notification->send(
      user: $property->owner->user,
      title: 'New Rental Request',
      message: "New rental request for {$property->name} from {$tenant->user->name}",
      action: route('owners.properties.applications', $property),
    );

    $this->notification->send(
      user: $tenant->user,
      title: 'Rental Request Submitted',
      message: "Your rental request for {$property->name} has been submitted successfully",
      action: route('tenants.applications', $property),
    );

    return redirect()
      ->route('tenants.applications')
      ->with('success', 'Rental request submitted successfully');
  }

  /**
   * Cancel the specified resource.
   */
  public function cancel(Property $property, Request $request): RedirectResponse
  {
    $this->check($property);

    $id = $request->get('id');
    $tenant = Auth::user()->tenant;
    $rented = $tenant->rented()
      ->where('property_id', $property->id)
      ->wherePivot('id', $id)
      ->first();

    if (!$rented) {
      return redirect()->back()
        ->with('error', 'Property not rented by the tenant');
    }

    if ($rented->pivot->status != StatusType::PENDING) {
      return redirect()->back()
        ->with('error', 'Rental request is not pending');
    }

    DB::beginTransaction();
    $rented->pivot->status = StatusType::CANCELLED;
    $rented->pivot->save();
    $property->increment('capacity');
    $property->save();
    DB::commit();

    $this->notification->send(
      user: $property->owner->user,
      title: 'Rental Request Cancelled',
      message: "Rental request for {$property->name} has been cancelled by {$tenant->user->name}",
      action: route('owners.properties.applications', $property),
    );

    $this->notification->send(
      user: $tenant->user,
      title: 'Rental Request Cancelled',
      message: "Your rental request for {$property->name} has been cancelled successfully",
      action: route('tenants.applications', $property),
    );

    return redirect()->back()->with('success', 'Rental request cancelled');
  }

  /**
   * Display the review form of the specified resource.
   */
  public function review(Property $property): RedirectResponse|View
  {
    $this->check($property);

    $tenant = Auth::user()->tenant;
    $rented = $tenant->rented()
      ->where('property_id', $property->id)
      ->wherePivotIn('status', [
        StatusType::APPROVED,
        StatusType::COMPLETED,
      ])
      ->get();

    $empty = $rented->isEmpty();

    if ($empty) {
      return redirect()->back()
        ->with('error', "Only tenant with approved or completed rentals can review the property");
    }

    return view('tenants.properties.review.create', [
      'property' => $property,
      'rented' => $rented,
    ]);
  }

  /**
   * Update user review of the specified resource.
   */
  public function update(HttpRequest $request, Property $property): RedirectResponse
  {
    $this->check($property);

    $id = $request->get('id');
    $tenant = Auth::user()->tenant;
    $rented = $tenant->rented()
      ->where('property_id', $property->id)
      ->wherePivot('id', $id)
      ->wherePivotIn('status', [
        StatusType::APPROVED,
        StatusType::COMPLETED,
      ])
      ->first();

    if (!$rented) {
      return redirect()->back()
        ->with('error', 'Property not rented by the tenant');
    }

    $validated = $request->validate([
      'id' => ['required', 'integer'],
      'rating' => ['required', 'integer', 'min:1', 'max:5'],
      'review' => ['required', 'string', 'max:255'],
    ]);

    $validated = (object) $validated;
    $rented->pivot->review = $validated->review;
    $rented->pivot->rating = $validated->rating;
    $rented->pivot->is_reviewed = true;
    $rented->pivot->save();

    $this->notification->send(
      user: $property->owner->user,
      title: 'Review updated',
      message: "Review for {$property->name} has been updated by {$tenant->user->name}",
      action: route('owners.properties.reviews', $property),
    );

    return redirect()->route('tenants.properties.reviews', $property)
      ->with('success', 'Review updated successfully');
  }
}
