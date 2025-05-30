<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\User;
use Illuminate\Contracts\View\View;

class AdminController extends Controller
{
  /**
   * Display the admin dashboard.
   */
  public function dashboard(): View
  {
    $users = User::count();
    $properties = Property::count();
    $unverified = Property::unverified()->count();
    $latest = Property::unverified()->with('owner')->latest()->take(5)->get();

    return view('admins.dashboard', [
      'users' => $users,
      'properties' => $properties,
      'unverified' => $unverified,
      'latest' => $latest,
    ]);
  }

  /**
   * Display the admin profile.
   */
  public function profile(): View
  {
    return view('admins.profile');
  }
}
