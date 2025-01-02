<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\RatingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/search', [GameController::class, 'search']);
Route::get('/index', [GameController::class, 'index']);


Route::post('/vote', [RatingController::class, 'vote']);
