<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProfileController::class, 'index'])->name('profiles.index');
Route::get('/profiles/{id}', [ProfileController::class, 'show'])->name('profiles.show');

// API routes for AJAX/Alpine.js
Route::prefix('api')->group(function () {
    Route::get('/profiles', [ProfileController::class, 'api'])->name('api.profiles');
});

// Test route for component system
Route::get('/test-components', function () {
    return view('test-components');
})->name('test.components');
