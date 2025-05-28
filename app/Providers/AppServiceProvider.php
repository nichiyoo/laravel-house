<?php

namespace App\Providers;

use App\Enums\RoleType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    Model::preventLazyLoading();

    Blade::if('role', function ($role) {
      $role = RoleType::tryFrom($role);
      return Auth::user()->role === $role;
    });
  }
}
