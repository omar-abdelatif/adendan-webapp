<?php

use App\Http\Controllers\MediaRole\MediaRoleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::prefix('admin/media')->group(function () {
    Route::middleware(['auth', 'role:media'])->group(function () {
        //! Home Page Routes
        Route::controller(MediaRoleController::class)->group(function () {
            Route::get('dashboard', 'MediaRole')->name('mediaRole.index');
        });
        
    });
});