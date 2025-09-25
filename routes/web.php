<?php

use App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProfileController::class, 'index'])->name('profiles.index');
Route::get('/profiles/{id}', [ProfileController::class, 'show'])->name('profiles.show');

// API routes for AJAX/Alpine.js
Route::prefix('api')->group(function () {
    Route::get('/profiles', [ProfileController::class, 'api'])->name('api.profiles');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Register Routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Email Verification Routes
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (Request $request) {
        if (! $request->hasValidSignature()) {
            abort(401);
        }

        $user = User::findOrFail($request->id);
        
        if (! hash_equals((string) $request->hash, sha1($user->getEmailForVerification()))) {
            abort(401);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('account.dashboard')->with('status', 'email-already-verified');
        }

        if ($user->markEmailAsVerified()) {
            event(new \Illuminate\Auth\Events\Verified($user));
        }

        return redirect()->route('account.dashboard')->with('status', 'email-verified');
    })->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    })->middleware('throttle:6,1')->name('verification.send');
});

// Logout Route (authenticated users only)
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');


// Account Routes (authenticated users only)
Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    // Dashboard
    Route::get('/', [AccountController::class, 'index'])->name('dashboard');
    
    // Profile Management
    Route::get('/profile', [AccountController::class, 'edit'])->name('edit');
    Route::patch('/profile', [AccountController::class, 'update'])->name('update');
    
    // Password Management
    Route::get('/password', [AccountController::class, 'showPasswordForm'])->name('password.edit');
    Route::patch('/password', [AccountController::class, 'updatePassword'])->name('password.update');
    
    // Additional Account Sections
    Route::get('/photos', [AccountController::class, 'showPhotos'])->name('photos');
    Route::get('/services', [AccountController::class, 'showServices'])->name('services');
    Route::get('/statistics', [AccountController::class, 'showStatistics'])->name('statistics');
    Route::get('/reviews', [AccountController::class, 'showReviews'])->name('reviews');
    
    // Delete Account
    Route::delete('/profile', [AccountController::class, 'destroy'])->name('destroy');
});

// Test route for component system
Route::get('/test-components', function () {
    return view('test-components');
})->name('test.components');
