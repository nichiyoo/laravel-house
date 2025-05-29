<?php

namespace App\Http\Controllers\Tenants;

use App\Enums\MethodType;
use App\Enums\StatusType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRentRequest;
use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PropertyController extends Controller
{
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

    $properties = Property::with('owner')
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
    return view('tenants.properties.show', [
      'property' => $property->load('owner'),
    ]);
  }

  /**
   * Display the reviews of the specified resource.
   */
  public function reviews(Property $property): View
  {
    return view('tenants.properties.reviews', [
      'property' => $property->load('owner'),
      'reviews' => $property->tenants()->with('user')->get(),
    ]);
  }

  /**
   * Display the location of the specified resource.
   */
  public function location(Property $property): View
  {
    return view('tenants.properties.location', [
      'property' => $property->load('owner'),
    ]);
  }

  /**
   * Bookmark the specified resource.
   */
  public function bookmark(Property $property): RedirectResponse
  {
    $tenant = Auth::user()->tenant;
    $tenant->bookmarks()->toggle($property);
    $bookmarked = $tenant->bookmarks->contains($property);

    return redirect()->back()->with('success', $bookmarked ? 'Property bookmarked successfully' : 'Property removed from bookmarks');
  }

  /**
   * Display the rent form of the specified resource.
   */
  public function rent(Property $property): View
  {
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
    $validated = $request->validated();
    $tenant = Auth::user()->tenant;

    DB::beginTransaction();
    $tenant->rented()->attach($property->id, [
      ...$validated,
      'review' => 'No review yet',
      'status' => StatusType::PENDING,
    ]);
    $property->decrement('capacity');
    $property->save();
    DB::commit();

    return redirect()
      ->route('tenants.properties.show', $property)
      ->with('success', 'rental request submitted successfully');
  }
}
