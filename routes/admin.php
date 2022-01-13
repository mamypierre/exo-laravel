<?php

use Illuminate\Support\Facades\Route;

Route::get('dashboard', 'ShowDashboard')->name('dashboard');
Route::resource('posts', 'PostController');
Route::resource('users', 'UserController')->only(['index', 'edit', 'update']);
