<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameCollection;
use App\Models\Game;

class CurrentRankingController extends Controller
{
    public function getCurrentRanking(): GameCollection
    {
        $topGames = Game::orderBy('score', 'desc')
            ->orderBy('votes', 'desc')
            ->limit(5)
            ->get();

        return new GameCollection($topGames);
    }
}
