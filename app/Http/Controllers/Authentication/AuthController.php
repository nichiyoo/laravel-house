<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Enums\RoleType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\RegisterRequest;

class AuthController extends Controller
{
  protected $intended = '/dashboard';

  /**
   * Show the login form.
   */
  public function login()
  {
    return view('auth.login');
  }

  /**
   * Show the register form.
   */
  public function register()
  {
    $roles = RoleType::save();

    return view('auth.register', [
      'roles' => $roles,
    ]);
  }

  /**
   * Handle login request
   */
  public function auth(LoginRequest $request)
  {
    $validated = $request->validated();

    $success = Auth::attempt($validated);
    if (!$success) return back()->with('error', 'Invalid credentials');

    $request->session()->regenerate();
    return redirect()->intended($this->intended);
  }

  /**
   * Handle register request
   */
  public function store(RegisterRequest $request)
  {
    $validated = $request->validated();
    $user = User::create($validated);

    match ($user->role) {
      RoleType::TENANT => $user->tenant()->create(),
      RoleType::OWNER => $user->owner()->create(),
      RoleType::ADMIN => $user->admin()->create(),
    };

    Auth::login($user);
    $request->session()->regenerate();

    return redirect($this->intended);
  }

  /**
   * Handle logout request
   */
  public function logout(Request $request)
  {
    Auth::guard('web')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect($this->intended);
  }
}
