<?php

namespace App\Http\Controllers\Owner;

use App\Enums\AmenityType;
use App\Enums\IntervalType;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use stdClass;

class PropertyController extends Controller
{
  /**
   * Register the middleware
   */
  public function __construct()
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

    $property = $owner->properties()->create($validated);
    $property->storeImage($request, 'backdrop');
    $property->storeImages($request, 'images');
    $property->save();

    return redirect()->route('owners.properties.index')
      ->with('success', 'property created successfully');
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
      'reviews' => $property->tenants()->with('user')->get(),
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
}
