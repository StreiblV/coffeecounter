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
});

Route::get('/privacy', function() {
    return view('privacy');
});

Route::get('/', function () {
    return view('welcome');
});