<?php

use Illuminate\Support\Facades\Route;


Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/dashboard', fn() => view('dashboard'))->middleware('auth')->name('dashboard');

require __DIR__ . '/auth.php';
