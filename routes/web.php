<?php

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

Route::get('/privacy', function() {
    return view('privacy');
});

Route::get('/', function () {
    return view('welcome');
});

# Authenticated routes

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');