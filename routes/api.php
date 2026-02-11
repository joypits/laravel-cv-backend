<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;

// Handle all OPTIONS preflight requests
Route::options('{any}', function () {
    return response()->json([], 200);
})->where('any', '.*');

Route::post('/login', [AuthController::class, 'login']); // optional
Route::post('/contact', [ContactController::class, 'store']);