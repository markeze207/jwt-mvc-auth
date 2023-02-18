<?php

use App\RMVC\Route\Route;

Route::get('/auth', [\App\Http\Controllers\AuthControllers::class, 'index']);
Route::post('/auth', [\App\Http\Controllers\AuthControllers::class, 'auth']);
Route::get('/profile', [\App\Http\Controllers\ProfileControllers::class, 'index']);
Route::post('/profile', [\App\Http\Controllers\ProfileControllers::class, 'check']);