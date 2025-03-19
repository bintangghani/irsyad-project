<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\KelompokController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.admin.dashboard');
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

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::controller(PermissionController::class)->prefix('permission')->name('permission.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::put('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });
    Route::controller(JenisController::class)->prefix('jenis')->name('jenis.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::put('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });
    Route::controller(KelompokController::class)->prefix('kelompok')->name('kelompok.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::put('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });
});