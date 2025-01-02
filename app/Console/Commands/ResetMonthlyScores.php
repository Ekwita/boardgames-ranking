<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Game;
use App\Models\Rating;
use App\Models\Podium;
use Illuminate\Support\Facades\Log;

class ResetMonthlyScores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scores:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset scores and save monthly top games to podium';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $month = Carbon::now()->subMonth()->format('Y-m');

        Log::info($month . ' is selected');

        $topGames = Game::orderByDesc('score')->take(3)->get();

        Log::info('Games are selected');

        $results = $topGames->map(function ($game) {
            return [
                'id' => $game->id,
                'name' => $game->name,
                'score' => $game->score,
            ];
        });

        Log::info('Result is created');

        Podium::create([
            'month' => $month,
            'results' => $results->toArray(),
        ]);

        Log::info('Podium is created');

        Rating::truncate();
        Log::info('Rating truncate');

        Game::query()->update(['score' => 0]);
        Log::info('Games score is cleared');

        $this->info("Podium for {$month} has been saved, and scores have been reset.");
        return 0;
    }
}
