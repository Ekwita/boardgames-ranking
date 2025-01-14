<?php

use App\Http\Controllers\ArchiveRankingController;
use App\Http\Controllers\CurrentRankingController;
use App\Http\Controllers\GameSearchController;
use App\Http\Controllers\GameVoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/search', [GameSearchController::class, 'search']);
Route::get('/index', [CurrentRankingController::class, 'getCurrentRanking']);


Route::post('/vote', [GameVoteController::class, 'vote']);

Route::get('/archive', [ArchiveRankingController::class, 'listArchivedRankings']);
