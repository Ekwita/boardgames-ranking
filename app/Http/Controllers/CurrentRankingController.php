<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameCollection;
use App\Services\Rankings\Interfaces\CurrentRankingServiceInterface;

class CurrentRankingController extends Controller
{
    public function __construct(protected CurrentRankingServiceInterface $currentRankingService) {}

    public function getCurrentRanking(): GameCollection
    {
        $currentRanking = $this->currentRankingService->getCurrentRanking();

        return $currentRanking;
    }
}
