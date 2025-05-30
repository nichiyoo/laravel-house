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
        return redirect()->route('tenants.dashboard');

      case RoleType::ADMIN:
        return redirect()->route('admins.dashboard');

      default:
        return redirect()->route('home');
    }
  }

  /**
   * Display the help page.
   *
   * @return \Illuminate\View\View
   */
  public function help()
  {
    return view('help');
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
        return redirect()->route('tenants.profile');

      case RoleType::ADMIN:
        return redirect()->route('admins.profile');

      default:
        return redirect()->route('home');
    }
  }
}
