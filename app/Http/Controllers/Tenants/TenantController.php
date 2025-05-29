<?php

namespace App\Http\Controllers\Tenants;

use App\Helpers\Distance;
use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use stdClass;
use Illuminate\View\View;

class TenantController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
   */
  public function dashboard()
  {
    $properties = Property::with('owner')
      ->where('capacity', '>', 0)
      ->get();

    $nearest = $properties->sortBy('distance')->take(5)->values();
    $latest = $properties->sortByDesc('updated_at')->take(10)->values();

    $combined_ids = [
      ...$latest->pluck('id'),
      ...$nearest->pluck('id'),
    ];

    $others = $properties->whereNotIn('id', $combined_ids)->take(8)->values();

    return view('tenants.dashboard', [
      'nearest' => $nearest,
      'latest' => $latest,
      'others' => $others,
    ]);
  }

  /**
   * Display a listing of the resource based on user location.
   * 
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\View\View
   */
  public function area(Request $request)
  {
    $location = new stdClass();
    $radius = $request->query('radius', 10);
    $location = $request->query('location', null);

    if ($location) {
      $location = json_decode($location);
    } else {
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
    }

    $radius = $request->query('radius', 10);

    $properties = Property::get()->filter(function ($property) use ($location, $radius) {
      $distance = Distance::haversine($location->latitude, $location->longitude, $property->latitude, $property->longitude);
      return $distance <= $radius;
    })->values();

    return view('tenants.area', [
      'properties' => $properties,
      'location' => $location,
      'radius' => $radius,
    ]);
  }

  /**
   * Display the profile page.
   *
   * @return \Illuminate\View\View
   */
  public function profile()
  {
    return view('tenants.profile');
  }

  /**
   * display tenant bookmarked properties
   */
  public function bookmarks(): View
  {
    $tenant = Auth::user()->tenant;
    $properties = $tenant->bookmarks()->with('owner')->get();

    return view('tenants.bookmarks', [
      'properties' => $properties,
    ]);
  }

  /**
   * display tenant rental applications
   */
  public function applications(): View
  {
    $tenant = Auth::user()->tenant;
    $properties = $tenant->rented()->with('owner')
      ->orderByPivot('created_at', 'desc')
      ->get();

    return view('tenants.applications', [
      'properties' => $properties,
    ]);
  }
}
