<?php

use App\Http\Controllers\Api\CitaApiController;
use Illuminate\Support\Facades\Route;

Route::get('/citas', [CitaApiController::class, 'index']);

Route::middleware('auth:sanctum')->post('/citas', [CitaApiController::class, 'store']);