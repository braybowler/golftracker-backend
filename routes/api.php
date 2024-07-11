<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GolfBagController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

//All api.php routes are prepended with /api
//For example: localhost/api/test

Route::get('/test', function () {
    return new Response(json_encode('A response from the Laravel api/test route.' . rand(1, 100)), 200);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);

Route::apiResource('golfbags', GolfBagController::class)->middleware('auth:sanctum');
