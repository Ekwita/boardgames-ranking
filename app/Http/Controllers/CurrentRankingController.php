<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameCollection;
use App\Services\Rankings\CurrentRankingService;

class CurrentRankingController extends Controller
{
    public function __construct(public CurrentRankingService $currentRankingService) {}

    public function getCurrentRanking(): GameCollection
    {
        $currentRanking = $this->currentRankingService->getCurrentRanking();

        return $currentRanking;
    }
}
