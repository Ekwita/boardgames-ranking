<?php

namespace App\Repositories\Interfaces;

use App\Dtos\GameRateDto;
use App\Dtos\VoteDto;
use App\Models\Game;

interface RatingRepositoryInterface
{
    public function createRating(Game $game, VoteDto $voteDto, GameRateDto $gameRateDto): void;
}
