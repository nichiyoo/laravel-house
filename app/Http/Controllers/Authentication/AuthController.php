<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  protected $intended = '/';

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
    return view('auth.register');
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

    Auth::login($user);
    return redirect($this->intended);
  }

  /**
   * Handle logout request
   */
  public function logout()
  {
    Auth::logout();
    return redirect($this->intended);
  }
}
