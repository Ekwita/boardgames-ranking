<?php

namespace App\Repositories\Interfaces;

use App\Dtos\GameRateDto;
use App\Models\Game;

interface GameRepositoryInterface
{
    public function findOrCreateGame(GameRateDto $gameRateDto): Game;
    public function updateGameScore(Game $game, GameRateDto $gameRateDto): void;
}
