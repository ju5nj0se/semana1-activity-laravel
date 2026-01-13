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

    Route::middleware(['role:admin|user'])->resource('users', \App\Http\Controllers\UserController::class);
    Route::middleware(['role:admin|user'])->get('/products', [\App\Http\Controllers\ProductController::class, 'index'])
        ->name('products.index');
    Route::middleware(['role:admin'])->resource('products', \App\Http\Controllers\ProductController::class)
        ->except(['index']);
    
    Route::middleware(['role:admin'])->get('/audits', [\App\Http\Controllers\AuditController::class, 'index'])
        ->name('audits.index');
});
