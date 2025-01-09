<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameCollection;
use App\Models\Game;
use Illuminate\Http\Request;

class CurrentRankingController extends Controller
{
    public function getCurrentRanking(): GameCollection
    {
        $topScores = Game::orderBy('score', 'desc')
            ->distinct()
            ->limit(5)
            ->pluck('score');

        $topGames = Game::whereIn('score', $topScores)
            ->orderBy('score', 'desc')
            ->limit(5)
            ->get();

        return new GameCollection($topGames);
    }
}
