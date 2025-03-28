<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\client\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\KelompokController;
use App\Http\Controllers\SubKelompokController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authentication;
use App\Http\Middleware\CheckLogin;
use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return redirect()->route('home');
});

Route::controller(ClientController::class)->group(function () {
    Route::get('/', 'index')->name('home');
});

Route::prefix('auth')->name('auth.')->group(function () {
    Route::controller(AuthenticationController::class)->group(function () {
        Route::middleware(CheckLogin::class)->group(function () {
            Route::get('/login', 'login')->name('login');
            Route::post('/login', 'loginAction')->name('loginAction');
            Route::get('/register', 'register')->name('register');
            Route::post('/register', 'registerAction')->name('registerAction');
            Route::get('/forgot-password', 'forgotPassword')->name('forgotPassword');
            Route::post('/forgot-password', 'forgotPasswordAction')->name('forgotPasswordAction');
            Route::get('/reset-password/{token}', 'showResetPasswordForm')->name('resetPassword.form');
            Route::post('/reset-password', 'resetPassword')->name('resetPassword.action');
        });
    });
});

Route::middleware(Authentication::class)->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });
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

    Route::controller(SubKelompokController::class)->prefix('subkelompok')->name('subkelompok.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });

    Route::controller(InstansiController::class)->prefix('instansi')->name('instansi.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::put('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::controller(RoleController::class)->prefix('role')->name('role.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit', 'edit')->name('edit');
            Route::post('/', 'store')->name('store');
            Route::put('/', 'update')->name('update');
            Route::delete('/', 'destroy')->name('destroy');
        });
    });

    Route::controller(UserController::class)->prefix('user')->name('user.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/', 'store')->name('store');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });
});