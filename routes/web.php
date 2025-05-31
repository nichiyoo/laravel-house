<?php

use App\Http\Controllers\Admins\AdminController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Owners\OwnerController;
use App\Http\Controllers\Tenants\TenantController;

use App\Http\Controllers\Admins\PropertyController as AdminPropertyController;
use App\Http\Controllers\Admins\ReportController;
use App\Http\Controllers\Owners\PropertyController as OwnerPropertyController;
use App\Http\Controllers\Tenants\PropertyController as TenantPropertyController;
use App\Http\Controllers\ChatController;

Route::get('', fn() => view('welcome'))->middleware('guest')->name('home');

Route::middleware('auth')
  ->controller(AppController::class)
  ->group(function () {
    Route::get('help', 'help')->name('help');
    Route::get('profile', 'profile')->name('profile');
    Route::get('dashboard', 'dashboard')->name('dashboard');

    Route::controller(NotificationController::class)
      ->prefix('notifications')
      ->as('notifications.')
      ->group(function () {
        Route::get('', 'index')->name('index');
        Route::put('read', 'read')->name('read');
        Route::put('read/all', 'all')->name('all');
        Route::delete('remove/all', 'purge')->name('purge');
        Route::delete('remove/{notification}', 'destroy')->name('destroy');
      });

    Route::controller(ChatController::class)
      ->prefix('chats')
      ->as('chats.')
      ->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('{target}', 'show')->name('show');
        Route::get('unread', 'unread')->name('unread');
        Route::post('{chat}/send', 'send')->name('send');
      });
  });

Route::middleware('auth', 'role:owner')
  ->prefix('owners')
  ->name('owners.')
  ->group(function () {
    Route::controller(OwnerController::class)
      ->group(function () {
        Route::get('profile', 'profile')->name('profile');
        Route::get('dashboard', 'dashboard')->name('dashboard');
        Route::get('applications', 'applications')->name('applications');
      });

    Route::controller(OwnerController::class)
      ->prefix('profile')
      ->as('profile.')
      ->group(function () {
        Route::get('edit', 'edit')->name('edit');
        Route::put('update', 'update')->name('update');
      });

    Route::controller(OwnerPropertyController::class)
      ->prefix('properties')
      ->as('properties.')
      ->group(function () {
        Route::get('{property}/tour', 'tour')->name('tour');
        Route::get('{property}/tour/{room}', 'room')->name('room');

        Route::get('{property}/reviews', 'reviews')->name('reviews');
        Route::get('{property}/location', 'location')->name('location');
        Route::get('{property}/applications', 'applications')->name('applications');
        Route::post('{property}/approve', 'approve')->name('approve');
        Route::post('{property}/reject', 'reject')->name('reject');
      });

    Route::resource('properties', OwnerPropertyController::class);
  });

Route::middleware('auth', 'role:tenant', 'completed')
  ->prefix('tenants')
  ->name('tenants.')
  ->group(function () {
    Route::controller(TenantController::class)
      ->group(function () {
        Route::get('area', 'area')->name('area');
        Route::get('dashboard', 'dashboard')->name('dashboard');
        Route::get('bookmarks', 'bookmarks')->name('bookmarks');
        Route::get('applications', 'applications')->name('applications');
        Route::get('profile', 'profile')->name('profile')->withoutMiddleware('completed');
      });

    Route::controller(TenantController::class)
      ->withoutMiddleware('completed')
      ->prefix('profile')
      ->as('profile.')
      ->group(function () {
        Route::get('edit', 'edit')->name('edit');
        Route::put('update', 'update')->name('update');
      });

    Route::controller(TenantPropertyController::class)
      ->prefix('properties')
      ->as('properties.')
      ->group(function () {
        Route::get('{property}/tour', 'tour')->name('tour');
        Route::get('{property}/tour/{room}', 'room')->name('room');

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

Route::middleware('auth', 'role:admin')
  ->prefix('admins')
  ->name('admins.')
  ->group(function () {
    Route::controller(AdminController::class)
      ->group(function () {
        Route::get('dashboard', 'dashboard')->name('dashboard');
        Route::get('profile', 'profile')->name('profile');
      });

    Route::controller(AdminPropertyController::class)
      ->prefix('properties')
      ->as('properties.')
      ->group(function () {
        Route::get('{property}/tour', 'tour')->name('tour');
        Route::get('{property}/tour/{room}', 'room')->name('room');

        Route::get('unverified', 'unverified')->name('unverified');
        Route::get('{property}/location', 'location')->name('location');
        Route::post('{property}/approve', 'approve')->name('approve');
      });

    Route::resource('properties', AdminPropertyController::class)->only('show');
    Route::resource('reports', ReportController::class);
  });

require __DIR__ . '/auth.php';
