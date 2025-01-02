<?php

namespace App\Repositories;

use App\Dtos\GameRateDto;
use App\Models\Game;

class GameRepository
{
    public function findOrCreateGame(GameRateDto $gameRateDto): Game
    {
        $game = Game::where('bgg_id', $gameRateDto->id)->first();

        if (!$game) {
            $game = Game::create([
                'bgg_id' => $gameRateDto->id,
                'name' => $gameRateDto->name,
            ]);
        }

        return $game;
    }

    public function updateGameScore(Game $game, GameRateDto $gameRateDto): void
    {
        $game->score += $gameRateDto->points;
        $game->save();
    }
}
