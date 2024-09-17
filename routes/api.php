<?php

use App\Http\Controllers\Api\BreweryApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('user', static function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function (): void {
    Route::get('breweries/{page?}/{limit?}', [BreweryApiController::class, 'index'])->name('api.breweries.index');
});
