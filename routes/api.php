<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::post('/post', [PostController::class, 'store']);
Route::post('/subscribe', [PostController::class, 'userSubscribe']);
