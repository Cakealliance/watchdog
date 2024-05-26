<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/site-loading-time', [\App\Http\Controllers\HealthCheckController::class, 'index'])->name('news');

Route::get('/metrics', [\App\Http\Controllers\MetricsController::class, 'index']);
