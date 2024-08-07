<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaggableController;
use App\Http\Controllers\GolfBagController;
use App\Http\Controllers\GolfBallController;
use App\Http\Controllers\GolfClubController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

//All api.php routes are prepended with /api
//For example: localhost/api/test

Route::get('/healthcheck', function () {
    return new Response(json_encode('Server is responding.'), 200);
});

Route::post('/login', [AuthController::class, 'login'])
    ->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum')
    ->name('auth.logout');
Route::post('/register', [AuthController::class, 'register'])
    ->name('auth.register');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('golfbags', GolfBagController::class);
    Route::apiResource('golfclubs', GolfClubController::class);
    Route::apiResource('golfballs', GolfBallController::class);
    Route::apiResource('baggables', BaggableController::class);
});
