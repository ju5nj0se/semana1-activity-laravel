<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::middleware(['role:admin'])->resource('users', \App\Http\Controllers\UserController::class);
    Route::middleware(['role:admin'])->resource('products', \App\Http\Controllers\ProductController::class);
});
