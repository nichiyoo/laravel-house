<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\Authentication\SocialiteController;

Route::middleware('guest')
  ->prefix('auth')
  ->as('auth.')
  ->group(function () {
    Route::controller(AuthController::class)->group(function () {
      Route::get('login', 'login')->name('login');
      Route::post('login', 'auth')->name('auth');
      Route::get('register', 'register')->name('register');
      Route::post('register', 'store')->name('store');
    });

    Route::controller(SocialiteController::class)->group(function () {
      Route::get('redirect/{provider}', 'redirect')->name('redirect');
      Route::get('callback/google', 'google')->name('google');
      Route::get('callback/github', 'github')->name('github');
    });
  });

Route::middleware('auth')
  ->prefix('auth')
  ->as('auth.')
  ->group(function () {
    Route::controller(AuthController::class)->group(function () {
      Route::post('logout', 'logout')->name('logout');
    });
  });
