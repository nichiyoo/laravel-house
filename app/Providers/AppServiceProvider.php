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

    Blade::if('owner', fn() => Auth::user()->role === RoleType::OWNER);
    Blade::if('admin', fn() => Auth::user()->role === RoleType::ADMIN);
    Blade::if('tenant', fn() => Auth::user()->role === RoleType::TENANT);
  }
}
