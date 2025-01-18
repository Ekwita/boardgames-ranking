<?php

namespace App\Actions;

use App\Models\Game;
use App\Models\Podium;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class MonthlyRankingResultAction
{
    public function __invoke(): void
    {
        $month = $this->setMonth();

        $topGames = $this->getBestGames();

        $results = $this->setResults($topGames);

        $this->createPodium($month, $results);

        $this->deleteOldRatings();

        $this->resetScores();

        Log::info("Podium for {$month} has been saved, and scores have been reset.");
    }

    private function setMonth(): string
    {
        $month = Carbon::now()->subMonth()->format('Y-m');

        Log::info($month . ' is selected');

        return $month;
    }

    private function getBestGames(): Collection
    {
        $topGames = Game::where('score', '>', 0)
            ->orderBy('score', 'desc')
            ->orderBy('votes', 'desc')
            ->limit(10)
            ->get();
        Log::info('Games are selected');

        return $topGames;
    }

    private function setResults(Collection $topGames): Collection
    {
        $topGames->map(function ($game) {
            return [
                'id' => $game->id,
                'name' => $game->name,
                'score' => $game->score,
            ];
        });

        Log::info('Result is created');

        return $topGames;
    }

    private function createPodium(string $month, Collection $results): void
    {
        Podium::create([
            'month' => $month,
            'results' => $results->toArray(),
        ]);

        Log::info('Podium is created');
    }

    private function deleteOldRatings(): void
    {
        Rating::truncate();
        Log::info('Rating truncate');
    }

    private function resetScores(): void
    {
        Game::query()->update(['score' => 0]);
        Log::info('Games score is cleared');
    }
}
