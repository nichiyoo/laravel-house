<?php

namespace App\Http\Controllers\Owners;

use App\Enums\StatusType;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\TenantProperty;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OwnerController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
   */
  public function dashboard()
  {
    $user = Auth::user();
    $owner = $user->owner;

    $properties = $owner->properties()->with('owner', 'tenants')->get();
    $populars = $properties->sortByDesc('rating')->values();

    $count = $properties->count();
    $rating = $properties->avg('rating');
    $reviews = $properties->sum('tenants_count');

    return view('owners.dashboard', [
      'properties' => $populars,
      'reviews' => $reviews,
      'count' => $count,
      'rating' => $rating,
    ]);
  }

  /**
   * Display the profile page.
   *
   * @return \Illuminate\View\View
   */
  public function profile()
  {
    return view('owners.profile');
  }

  /**
   * Display the owner rental applications.
   */
  public function applications(): View
  {
    $owner = Auth::user()->owner;
    $properties = $owner->properties()
      ->whereHas('tenants', function ($query) {
        $query->where('status', StatusType::PENDING);
      })
      ->with('tenants')
      ->get();

    return view('owners.applications', [
      'properties' => $properties,
    ]);
  }
}
