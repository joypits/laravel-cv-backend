<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']); // optional
Route::post('/contact', [ContactController::class, 'store']);