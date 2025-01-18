<?php

namespace App\Services\Rankings;

use App\Http\Resources\GameCollection;
use App\Models\Game;
use App\Services\Rankings\Interfaces\CurrentRankingServiceInterface;

class CurrentRankingService implements CurrentRankingServiceInterface
{
    public function getCurrentRanking(): GameCollection
    {
        $topGames = Game::where('score', '>', 0)
            ->orderBy('score', 'desc')
            ->orderBy('votes', 'desc')
            ->limit(10)
            ->get();

        return new GameCollection($topGames);
    }
}
