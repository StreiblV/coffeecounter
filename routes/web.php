<?php

use App\Http\Controllers\Api\V1\EntryController;
use App\Http\Controllers\Api\V1\LeaderboardController;
use App\Http\Controllers\Api\V1\AiSummaryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public routes
Route::view('/welcome', 'welcome');
Route::view('/register', 'register');
Route::view('/login', 'login')->name('login');
Route::view('/privacy', 'privacy');

// Logout route
Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

// Redirect root to welcome page
Route::redirect('/', '/welcome');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [EntryController::class, 'render']);
    Route::get('/ai-summary', [AiSummaryController::class, 'generateSummary']);
    Route::view('/analytics', 'analytics');
    Route::get('/leaderboard', [LeaderboardController::class, 'render']);
    Route::view('/socialmedia', 'socialmedia');
    Route::get('/preferences', function () {
        return view('preferences', ['user' => Auth::user()]);
    });
});
