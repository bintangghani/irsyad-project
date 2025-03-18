<?php


use App\Http\Controllers\PermissionController;
use App\Models\Permission;
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

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::controller(PermissionController::class)->prefix('permission')->name('permission.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::put('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy'); 
    });
});