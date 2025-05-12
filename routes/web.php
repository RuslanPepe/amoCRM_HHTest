<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AmoAuthController;

Route::get('/', function () {return view('welcome');});
Route::get('/auth/redirect', [AmoAuthController::class, 'redirect']);
Route::get('/oauth/callback', [AmoAuthController::class, 'callback']);
