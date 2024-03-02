<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::view('/', 'welcome');
Route::view('login', 'auth.login');
