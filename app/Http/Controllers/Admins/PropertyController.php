<?php

namespace App\Http\Controllers\Admins;

use App\Enums\StatusType;
use App\Enums\VerificationType;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class PropertyController extends Controller
{
  public function __construct(private NotificationService $notification)
  {
    Gate::define('check', function (User $user, Property $property) {
      return $property->verification === VerificationType::UNVERIFIED;
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
   * Display a listing of unverified properties.
   */
  public function unverified(): View
  {
    $keyword = request()->get('query');

    $properties = Property::unverified()
      ->with('owner')
      ->when($keyword, function ($query) use ($keyword) {
        return $query->where(function ($q) use ($keyword) {
          $q->where('name', 'like', '%' . $keyword . '%')
            ->orWhere('city', 'like', '%' . $keyword . '%')
            ->orWhere('region', 'like', '%' . $keyword . '%')
            ->orWhere('address', 'like', '%' . $keyword . '%')
            ->orWhere('zipcode', 'like', '%' . $keyword . '%')
            ->orWhere('description', 'like', '%' . $keyword . '%');
        });
      })
      ->get();

    return view('admins.properties.unverified', [
      'properties' => $properties,
    ]);
  }

  /**
   * Display a single property.
   */
  public function show(Property $property): View
  {
    $this->check($property);

    return view('admins.properties.show', [
      'property' => $property,
    ]);
  }

  /**
   * Display the location of the specified resource.
   */
  public function location(Property $property): View
  {
    $this->check($property);

    return view('admins.properties.location', [
      'property' => $property->load('owner'),
    ]);
  }

  /**
   * Display the virtual tour of the specified resource.
   */
  public function tour(Property $property): RedirectResponse
  {
    $this->check($property);

    $images = $property->images;
    if (!$images) return redirect()->back()->with('error', 'Property has no images');

    return redirect()->route('admins.properties.room', [
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

    return view('admins.properties.tour', [
      'property' => $property,
      'room' => $images[$room],
      'images' => $images,
    ]);
  }

  /**
   * Approve the specified property.
   */
  public function approve(Property $property): RedirectResponse
  {
    $this->check($property);

    $property->update([
      'verification' => VerificationType::VERIFIED,
    ]);

    $this->notification->send(
      user: $property->owner->user,
      title: 'Property approved',
      message: 'Your property ' . $property->name . ' has been approved by the admin',
      action: route('owners.properties.show', $property),
    );

    return redirect()->back()
      ->with('success', 'Property approved successfully');
  }
}
