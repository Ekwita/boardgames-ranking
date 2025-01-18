<?php

namespace App\Services\Rankings\Interfaces;

use App\Http\Resources\GameCollection;

interface CurrentRankingServiceInterface
{
    public function getCurrentRanking(): GameCollection;
}