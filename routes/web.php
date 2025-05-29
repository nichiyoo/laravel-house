<?php

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Owners\PropertyController;
use App\Http\Controllers\Owners\OwnerController;

use App\Http\Controllers\Tenants\TenantController;
use App\Http\Controllers\Tenants\PropertyController as TenantPropertyController;

Route::get('/', fn() => view('welcome'))->middleware('guest')->name('home');

Route::middleware('auth')
  ->controller(AppController::class)
  ->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/activity', 'activity')->name('activity');
    Route::get('/profile', 'profile')->name('profile');
  });

Route::middleware('auth', 'role:owner')
  ->prefix('owners')
  ->name('owners.')
  ->group(function () {
    Route::controller(OwnerController::class)
      ->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/profile', 'profile')->name('profile');
      });

    Route::controller(PropertyController::class)
      ->prefix('properties')
      ->as('properties.')
      ->group(function () {
        Route::get('{property}/reviews', 'reviews')->name('reviews');
        Route::get('{property}/location', 'location')->name('location');
      });

    Route::resource('properties', PropertyController::class);
  });

Route::middleware('auth', 'role:tenant')
  ->prefix('tenants')
  ->name('tenants.')
  ->group(function () {
    Route::controller(TenantController::class)
      ->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/profile', 'profile')->name('profile');
        Route::get('/area', 'area')->name('area');

        Route::get('/bookmarks', 'bookmarks')->name('bookmarks');
        Route::get('/applications', 'applications')->name('applications');
      });

    Route::controller(TenantPropertyController::class)
      ->prefix('properties')
      ->as('properties.')
      ->group(function () {
        Route::get('{property}/rent', 'rent')->name('rent');
        Route::post('{property}/rent', 'store')->name('store');
        Route::get('{property}/reviews', 'reviews')->name('reviews');
        Route::get('{property}/location', 'location')->name('location');
        Route::post('{property}/bookmark', 'bookmark')->name('bookmark');
      });

    Route::resource('properties', TenantPropertyController::class)->only('index', 'show');
  });

require __DIR__ . '/auth.php';
