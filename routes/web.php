<?php

use App\Http\Controllers\BreweryController;
use App\Http\Controllers\DashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', static function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function (): void {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware([
    'auth:sanctum',
])->group(function (): void {
    Route::get('breweries', [BreweryController::class, 'index'])->name('breweries.index');
});
