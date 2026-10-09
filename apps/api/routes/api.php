<?php

use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'service' => 'comentaro-api',
        'version' => config('app.version'),
        'timestamp' => now()->toISOString(),
    ]);
})->name('api.health');
