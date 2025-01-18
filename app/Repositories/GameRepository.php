<?php

namespace App\Repositories;

use App\Dtos\GameRateDto;
use App\Models\Game;
use App\Repositories\Interfaces\GameRepositoryInterface;

class GameRepository implements GameRepositoryInterface
{
    public function findOrCreateGame(GameRateDto $gameRateDto): Game
    {
        $game = Game::where('bgg_id', $gameRateDto->id)->first();

        if (!$game) {
            $game = Game::create([
                'bgg_id' => $gameRateDto->id,
                'name' => $gameRateDto->name,
                'image' => $gameRateDto->image
            ]);
        }

        return $game;
    }

    public function updateGameScore(Game $game, GameRateDto $gameRateDto): void
    {
        $game->score += $gameRateDto->points;
        $game->votes++;
        $game->save();
    }
}
