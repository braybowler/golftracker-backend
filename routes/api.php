<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GolfBagController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

//All api.php routes are prepended with /api
//For example: localhost/api/test

Route::get('/healthcheck', function () {
    return new Response(json_encode('Server is responding.'), 200);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('golfbags', GolfBagController::class);
});
