<?php

namespace App\Http\Controllers\Owners;

use App\Enums\StatusType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
   * Display the edit profile page.
   *
   * @return \Illuminate\View\View
   */
  public function edit()
  {
    return view('owners.profile.edit');
  }

  /**
   * Update the profile.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Request $request)
  {
    $user = Auth::user();

    $request->validate([
      'name' => ['required', 'string', 'max:32'],
      'phone' => ['required', 'string', 'max:16'],
      'avatar' => ['nullable', 'image', 'max:1024'],
      'password' => ['nullable', 'string', 'min:8', 'confirmed'],
    ]);

    $password = $request->has('password');
    if (!$password) $validated = $request->only('name', 'phone');
    else $validated = $request->only('name', 'phone', 'password');

    $user->update($validated);
    $user->storeImage($request, 'avatar');
    $user->save();

    return redirect()->route('owners.profile')->with('success', 'Profile updated successfully');
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
