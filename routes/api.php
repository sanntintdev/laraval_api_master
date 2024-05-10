<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// universal resource locater

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(
    'auth:sanctum'
);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
