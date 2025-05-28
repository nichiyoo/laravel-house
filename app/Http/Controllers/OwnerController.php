<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

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
}
