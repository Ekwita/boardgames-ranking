<?php

namespace App\Repositories;

use App\Dtos\GameRateDto;
use App\Dtos\VoteDto;
use App\Models\Game;
use App\Models\Rating;

class RatingReposiotry
{
    public function createRating(Game $game, VoteDto $voteDto, GameRateDto $gameRateDto): void
    {
        Rating::create([
            'game_id' => $game->id,
            'points' => $gameRateDto->points,
            'user_name' => $voteDto->userName,
            'email' => $voteDto->email,
            'voted_at' => $voteDto->votedAt,
        ]);
    }
}
