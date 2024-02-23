<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/','welcome');

Auth::routes();
Route::middleware('auth')->group(function(){
    Route::controller(HomeController::class)->group(function(){
        Route::view('/home', 'index')->name('home');
        // Route::get('/home', 'index')->name('home');
    });
});
