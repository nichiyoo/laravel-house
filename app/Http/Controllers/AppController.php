<?php

namespace App\Http\Controllers;

use App\Enums\RoleType;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
  /**
   * Redirect to the appropriate dashboard based on the user's role.
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function dashboard()
  {
    $user = Auth::user();
    $role = $user->role;

    switch ($role) {
      case RoleType::OWNER:
        return redirect()->route('owners.dashboard');

      case RoleType::TENANT:
      case RoleType::ADMIN:
      default:
        return redirect()->route('home');
    }
  }

  /**
   * Display the activity page.
   *
   * @return \Illuminate\View\View
   */
  public function activity()
  {
    return view('activity');
  }

  /**
   * Redirect to the appropriate profile page based on the user's role.
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function profile()
  {
    $user = Auth::user();
    $role = $user->role;

    switch ($role) {
      case RoleType::OWNER:
        return redirect()->route('owners.profile');

      case RoleType::TENANT:
      case RoleType::ADMIN:
      default:
        return redirect()->route('home');
    }
  }
}
