<?php

use App\Http\Controllers\Api\V1\EntryController;
use App\Http\Controllers\Api\V1\LeaderboardController;
use App\Models\Entry;
use Illuminate\Support\Facades\Route;


Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/register', function() {
    return view('register');
});

Route::get('/login', function() {
    return view('login');
})->name("login");

Route::get('/logout', function() {
    Auth::logout();

    return redirect("login");
});

Route::get('/privacy', function() {
    return view('privacy');
});

Route::get('/', function () {
    return view('welcome');
});

# Authenticated routes

Route::get('/dashboard', [EntryController::class, "render"])->middleware('auth');

Route::get('/analytics', function () {
    return view('analytics');
})->middleware('auth');

Route::get('/leaderboard', [LeaderboardController::class, "render"])->middleware('auth');

Route::get('/socialmedia', function () {
    return view('socialmedia');
})->middleware('auth');

Route::get('/preferences', function () {
    $user = Auth::user();
    return view('preferences', ["user" => $user]);
})->middleware('auth');
