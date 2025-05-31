<?php

namespace App\Http\Controllers\Authentication;

use App\Enums\RoleType;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
  protected $intended = '/';

  /**
   * redirect to oauth provider
   */
  public function redirect(string $provider)
  {
    return Socialite::driver($provider)->redirect();
  }

  /**
   * handle google oauth callback
   */
  public function google()
  {
    $social = Socialite::driver('google')->user();

    $user = User::updateOrCreate([
      'email' => $social->email,
      'google_id' => $social->id,
    ], [
      'name' => $social->name,
      'avatar' => $social->avatar,
      'google_token' => $social->token,
      'google_refresh_token' => $social->refreshToken,
    ]);

    $user->role = RoleType::TENANT;
    $user->tenant()->create();
    $user->save();

    Auth::login($user);
    return redirect($this->intended);
  }

  /**
   * handle github oauth callback
   */
  public function github()
  {
    $social = Socialite::driver('github')->user();

    $user = User::updateOrCreate([
      'email' => $social->email,
      'github_id' => $social->id,
    ], [
      'name' => $social->name,
      'avatar' => $social->avatar,
      'github_token' => $social->token,
      'github_refresh_token' => $social->refreshToken,
    ]);

    $user->role = RoleType::TENANT;
    $user->tenant()->create();
    $user->save();

    Auth::login($user);
    return redirect($this->intended);
  }
}
