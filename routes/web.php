<?php

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Owner\PropertyController;
use App\Http\Controllers\OwnerController;

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

require __DIR__ . '/auth.php';
