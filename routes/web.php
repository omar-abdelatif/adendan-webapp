<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::view('/','welcome');

Auth::routes();
Route::prefix('admin')->group(function () {
    Route::view('login', 'auth.login');
    Route::middleware('auth')->group(function () {
        Route::controller(HomeController::class)->group(function () {
            Route::get('dashboard', 'index')->name('home');
        });
    });
});
