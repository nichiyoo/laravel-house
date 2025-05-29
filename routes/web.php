<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Owners\OwnerController;
use App\Http\Controllers\Owners\PropertyController as OwnerPropertyController;

use App\Http\Controllers\Tenants\TenantController;
use App\Http\Controllers\Tenants\PropertyController as TenantPropertyController;

Route::get('/', fn() => view('welcome'))->middleware('guest')->name('home');

Route::middleware('auth')
  ->controller(AppController::class)
  ->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/profile', 'profile')->name('profile');
    Route::get('/help', 'help')->name('help');

    Route::controller(NotificationController::class)
      ->prefix('notifications')
      ->as('notifications.')
      ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::put('/read', 'read')->name('read');
        Route::put('/read/all', 'all')->name('all');
        Route::delete('/remove/all', 'purge')->name('purge');
        Route::delete('/remove/{notification}', 'destroy')->name('destroy');
      });
  });

Route::middleware('auth', 'role:owner')
  ->prefix('owners')
  ->name('owners.')
  ->group(function () {
    Route::controller(OwnerController::class)
      ->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/profile', 'profile')->name('profile');
        Route::get('/applications', 'applications')->name('applications');
      });

    Route::controller(OwnerPropertyController::class)
      ->prefix('properties')
      ->as('properties.')
      ->group(function () {
        Route::get('{property}/reviews', 'reviews')->name('reviews');
        Route::get('{property}/location', 'location')->name('location');
        Route::get('{property}/applications', 'applications')->name('applications');
        Route::post('{property}/approve', 'approve')->name('approve');
        Route::post('{property}/reject', 'reject')->name('reject');
      });

    Route::resource('properties', OwnerPropertyController::class);
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
        Route::post('{property}/cancel', 'cancel')->name('cancel');
        Route::get('{property}/reviews', 'reviews')->name('reviews');
        Route::get('{property}/location', 'location')->name('location');
        Route::post('{property}/bookmark', 'bookmark')->name('bookmark');

        Route::put('{property}/reviews', 'update')->name('update');
        Route::get('{property}/reviews/create', 'review')->name('review.create');
      });

    Route::resource('properties', TenantPropertyController::class)->only('index', 'show');
  });

require __DIR__ . '/auth.php';
