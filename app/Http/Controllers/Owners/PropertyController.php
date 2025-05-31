<?php

namespace App\Http\Controllers\Owners;

use App\Enums\AmenityType;
use App\Enums\IntervalType;
use App\Enums\RoleType;
use App\Enums\StatusType;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use stdClass;

class PropertyController extends Controller
{
  /**
   * Register the middleware
   */
  public function __construct(private NotificationService $notification)
  {
    $this->authorizeResource(Property::class, 'property');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request): View
  {
    $query = $request->get('query');
    $owner = Auth::user()->owner;

    $property = Property::where('owner_id', $owner->id)
      ->when($query, function ($q) use ($query) {
        return $q->where(function ($builder) use ($query) {
          $builder->where('name', 'like', '%' . $query . '%')
            ->orWhere('city', 'like', '%' . $query . '%')
            ->orWhere('region', 'like', '%' . $query . '%')
            ->orWhere('address', 'like', '%' . $query . '%')
            ->orWhere('zipcode', 'like', '%' . $query . '%');
        });
      })
      ->get();

    return view('owners.properties.index', [
      'properties' => $property->load('owner'),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create(): View
  {
    $location = new stdClass();

    try {
      $response = Http::get('http://ip-api.com/json');
      $location = (object)[
        'latitude' => $response->json('lat'),
        'longitude' => $response->json('lon'),
      ];
    } catch (\Exception $e) {
      $location = (object)[
        'latitude' => -6.200000,
        'longitude' => 106.816666,
      ];
    }

    return view('owners.properties.create', [
      'location' => $location,
      'amenities' => AmenityType::cases(),
      'intervals' => IntervalType::cases(),
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StorePropertyRequest $request): RedirectResponse
  {
    $validated = $request->except('backdrop', 'images');
    $owner = Auth::user()->owner;

    try {
      DB::beginTransaction();

      $property = $owner->properties()->create($validated);
      $property->storeImage($request, 'backdrop');
      $property->storeImages($request, 'images');
      $property->save();

      $admins = User::where('role', RoleType::ADMIN)->get();
      $this->notification->broadcast(
        $admins,
        'New property created',
        'A new property has been created by ' . $owner->user->name,
      );

      DB::commit();

      return redirect()->route('owners.properties.index')
        ->with('success', 'property created successfully');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()
        ->with('error', 'property creation failed');
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(Property $property): View
  {
    return view('owners.properties.show', [
      'property' => $property->load('owner'),
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Property $property): View
  {
    $location = (object)[
      'latitude' => $property->latitude,
      'longitude' => $property->longitude,
    ];

    return view('owners.properties.edit', [
      'property' => $property,
      'location' => $location,
      'amenities' => AmenityType::cases(),
      'intervals' => IntervalType::cases(),
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdatePropertyRequest $request, Property $property): RedirectResponse
  {
    $validated = $request->except('backdrop', 'images');

    $property->update($validated);
    $property->storeImage($request, 'backdrop');
    $property->storeImages($request, 'images');
    $property->save();

    return redirect()->route('owners.properties.index')
      ->with('success', 'property updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Property $property): RedirectResponse
  {
    $property->delete();
    $property->deleteImage('backdrop');
    $property->deleteImages('images');

    return redirect()->route('owners.properties.index')
      ->with('success', 'property deleted successfully');
  }

  /**
   * Display the reviews of the specified resource.
   */
  public function reviews(Property $property): View
  {
    return view('owners.properties.reviews', [
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
    return view('owners.properties.location', [
      'property' => $property->load('owner'),
    ]);
  }

  /**
   * Display the applications of the specified resource.
   */
  public function applications(Property $property): View
  {
    return view('owners.properties.applications', [
      'property' => $property->load('owner'),
      'tenants' => $property->tenants()
        ->with('user')
        ->orderByPivot('created_at', 'desc')
        ->get(),
    ]);
  }

  /**
   * Approve the specified resource.
   */
  public function approve(Request $request, Property $property): RedirectResponse
  {
    $id = $request->input('id');
    $rental = $property->tenants()->with('user')
      ->wherePivot('id', $id)
      ->first();

    if (!$rental) {
      return redirect()->route('owners.properties.applications', $property)
        ->with('error', 'tenant not found');
    }

    if ($rental->pivot->status !== StatusType::PENDING) {
      return redirect()->route('owners.properties.applications', $property)
        ->with('error', 'tenant not pending');
    }

    $rental->pivot->update([
      'status' => StatusType::APPROVED,
    ]);

    $this->notification->send(
      $rental->user,
      'Your application has been approved',
      'Your application has been approved for ' . $property->name,
    );

    return redirect()->route('owners.properties.applications', $property)
      ->with('success', 'tenant approved successfully');
  }

  /**
   * Reject the specified resource.
   */
  public function reject(Request $request, Property $property): RedirectResponse
  {
    $id = $request->input('id');
    $rental = $property->tenants()->with('user')
      ->wherePivot('id', $id)
      ->first();

    if (!$rental) {
      return redirect()->route('owners.properties.applications', $property)
        ->with('error', 'tenant not found');
    }

    if ($rental->pivot->status !== StatusType::PENDING) {
      return redirect()->route('owners.properties.applications', $property)
        ->with('error', 'tenant not pending');
    }

    $rental->pivot->update([
      'status' => StatusType::REJECTED,
    ]);

    $this->notification->send(
      $rental->user,
      'Your application has been rejected',
      'Your application has been rejected for ' . $property->name,
    );

    return redirect()->route('owners.properties.applications', $property)
      ->with('success', 'tenant rejected successfully');
  }
}
