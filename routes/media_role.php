<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TombsController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\MediaRole\MediaRoleController;

Auth::routes();

Route::prefix('media')->group(function () {
    Route::middleware(['auth', 'role:media'])->group(function () {
        //! Home Page Routes
        Route::prefix('dashboard')->group(function () {
            Route::controller(MediaRoleController::class)->group(function () {
                Route::get('main', 'MediaRole')->name('mediaRole.index');
            });
        });
        Route::prefix('news')->group(function () {
            Route::controller(NewsController::class)->group(function () {
                Route::get('all', 'index')->name('mediaRole.news.all');
                Route::post('store_news', 'storeNews')->name('mediaRole.news.store');
                Route::get('delete_news/{id}', 'destroyNews')->name('mediaRole.news.destroy');
                Route::post('update_news', 'updateNews')->name('mediaRole.news.update');
                Route::get('all_news/all_thumbs/{id}', 'showThumbnails')->name('mediaRole.show.thumbs');
                Route::get('delete_single_thumbs/{id}', 'deleteSingleImage')->name('mediaRole.thumbs.delete');
                Route::get('delete_video/{id}', 'deleteVideo')->name('mediaRole.video.delete');
                Route::post('update_video', 'updateVideo')->name('mediaRole.video.update');
                Route::post('store_video/{id}', 'storeVideo')->name('mediaRole.video.store');
            });
        });
        Route::prefix('workers')->group(function () {
            Route::controller(WorkerController::class)->group(function () {
                Route::get('all', 'index')->name('mediaRole.workers.all');
                Route::post('store', 'storeWorker')->name('mediaRole.worker.store');
                Route::get('delete/{id}', 'delete')->name('mediaRole.worker.delete');
                Route::post('update', 'update')->name('mediaRole.worker.update');
            });
        });
        Route::prefix('tombs')->group(function () {
            Route::controller(TombsController::class)->group(function () {
                Route::get('all', 'index')->name('mediaRole.tomb.all');
                Route::post('store', 'storeTomb')->name('mediaRole.tomb.store');
                Route::get('delete/{id}', 'deleteTomb')->name('mediaRole.tomb.delete');
                Route::post('update', 'updateTomb')->name('mediaRole.tomb.update');
            });
        });
    });
});
