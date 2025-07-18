<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\BookmarksController;
use App\Http\Controllers\client\ClientController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\KelompokController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SiteSettingsController;
use App\Http\Controllers\SubKelompokController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authentication;
use App\Http\Middleware\CheckLogin;
use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return redirect()->route('home');
});

Route::prefix('client')->name('client.')->group(function () {});
Route::controller(ClientController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/buku/{id}', 'showBuku')->name('show');
    Route::get('/category', 'category')->name('category');
    Route::get('/instansi', 'instansi')->name('instansi');
    Route::get('/instansi/{id}', 'showInstansi')->name('instansi.show');
    Route::get('/read/{id}', 'readBook')->name('read');
    Route::get('/profile', 'profile')->name('client.profile');
    Route::get('/profile/{id}', 'profile')->name('client.profile.show');
    Route::put('/profile/{id}', 'updateClientProfile')->name('updateClientProfile');
    Route::get('search', 'search')->name('searchBuku');
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
        Route::get('/logout', 'logoutAction')->name('logoutAction');
    });
});

Route::middleware(Authentication::class)->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/chart-data', 'getChartData')->name('dashboard.chart-data');
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::controller(RoleController::class)->prefix('role')->name('role.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });

        Route::controller(PermissionController::class)->prefix('permission')->name('permission.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });

        Route::controller(InstansiController::class)->prefix('instansi')->name('instansi.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
            Route::get('/profile/{id}', 'profileInstansi')->name('instansi.profile.show');
            Route::put('/update-profile/{id}',  'updateProfile')->name('updateProfile');
            Route::get('/import', 'importForm')->name('import.form');
            Route::post('/import', 'import')->name('import');
        });
    });

    Route::controller(UserController::class)->prefix('user')->name('user.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/', 'store')->name('store');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
        Route::get('/profile/{id}', 'profile')->name('user.profile.show');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('edit/profile/{id}', 'profile')->name('user.profile.edit');
        Route::put('/profile/{id}', 'updateProfile')->name('updateProfile');
    });

    Route::prefix('buku')->name('buku.')->group(function () {
        Route::controller(JenisController::class)->prefix('jenis')->name('jenis.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });

        Route::controller(KelompokController::class)->prefix('kelompok')->name('kelompok.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });

        Route::controller(SubKelompokController::class)->prefix('subkelompok')->name('subkelompok.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });
    });

    Route::controller(BukuController::class)->prefix('buku')->name('buku.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/', 'store')->name('store');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('/show/{id}', 'show')->name('show');
        Route::post('/read/{id}', 'read')->name('read');
        Route::get('/import', 'importForm')->name('import.form');
        Route::post('/import', 'import')->name('import');
    });

    Route::controller(BookmarksController::class)->prefix('bookmarks')->name('bookmarks.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    Route::controller(SiteSettingsController::class)->prefix('site')->name('site.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
    });

    Route::controller(LaporanController::class)->prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/export', 'export')->name('export');
    });
});
