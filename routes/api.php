<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerWebHook;

Route::post('/webhook', [ControllerWebHook::class, 'handler']);
