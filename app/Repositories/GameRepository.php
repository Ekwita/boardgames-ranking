<?php

namespace App\Repositories;

use App\Dtos\GameRateDto;
use App\Models\Game;
use App\Repositories\Interfaces\GameRepositoryInterface;
use Illuminate\Support\Facades\Http;

class GameRepository implements GameRepositoryInterface
{
    public function findOrCreateGame(GameRateDto $gameRateDto): Game
    {
        $game = Game::where('bgg_id', $gameRateDto->id)->first();

        if (!$game) {
            $game = Game::create([
                'bgg_id' => $gameRateDto->id,
                'name' => $gameRateDto->name,
                'image' => is_null($gameRateDto->image) ? $this->addMissingImage($gameRateDto->id) : $gameRateDto->image,
            ]);
        }

        return $game;
    }

    public function updateGameScore(Game $game, GameRateDto $gameRateDto): void
    {
        if (is_null($game->image)) {
            $game->image = $this->addMissingImage($gameRateDto->id);
        }
        $game->score += $gameRateDto->points;
        $game->votes++;
        $game->save();
    }

    private function addMissingImage(int $bggId): ?string
    {
        $response = Http::get("https://boardgamegeek.com/xmlapi2/thing?id={$bggId}");

        $detailXml = simplexml_load_string($response->body());
        $detail = $detailXml->item;

        if ($detail) {
            $thumbnail = $detail->image ?? null;
            return $thumbnail ? (string) $thumbnail : '';
        }
    }
}
