<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->name('auth')->group(function () {
    Route::get('/', function () {
        return view('pages.auth.auth');
    });
    Route::get('/login', function () {
        return view('pages.auth.login');
    });
    Route::get('/register', function () {
        return view('pages.auth.register');
    });
});
