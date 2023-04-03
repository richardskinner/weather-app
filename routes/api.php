<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/city', [\App\Http\Controllers\CityController::class, 'store'])->name('api.city.store');
Route::get('/weather/{cityParam?}', [\App\Http\Controllers\WeatherController::class, 'get'])->name('api.weather.get');
