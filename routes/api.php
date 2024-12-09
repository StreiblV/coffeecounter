<?php

use App\Http\Controllers\Api\V1\Auth\UserController;
use App\Http\Middleware\AuthenticateOnceWithBasicAuth;

Route::get('/token', [UserController::class, "token"])
    ->middleware(AuthenticateOnceWithBasicAuth::class);

Route::get('/users', [UserController::class, "findAll"])
    ->middleware("auth:sanctum");

Route::post('/users', [UserController::class, "create"])
    ->middleware("auth:sanctum");
