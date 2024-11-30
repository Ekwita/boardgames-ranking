<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RatingController extends Controller
{
    public function vote(Request $request)
    {
        $userName = $request->input('username');
        $email = $request->input('email');
        Log::info('Hey ' . $userName . '. Your email ' . $email . ' is correct.');

        // foreach ($votes as $vote) {
        //     $gameId = $vote['id'];
        //     $points = $vote['points'];

        // }

        $currentMonth = Carbon::now()->format('Y-m');

        Log::info('Current month is ' . $currentMonth);

        $existingVotes = Rating::where('email', $email)
            ->whereYear('voted_at', Carbon::now()->year) // Sprawdzamy, czy rok zgadza się z aktualnym
            ->whereMonth('voted_at', Carbon::now()->month) // Sprawdzamy, czy miesiąc zgadza się z aktualnym
            ->exists();

        if ($existingVotes) {
            return response()->json(['message' => 'You have already voted this month'], 403);
        }

        $votes = $request->input('votes');


        foreach ($votes as $vote) {
            $gameId = $vote['id'];
            $gameName = $vote['name'];
            $points = $vote['points'];
            Log::info('Game id is ' . $gameId . '. Game name is ' . $gameName . '. It has ' . $points . ' points.');


            $game = Game::where('bgg_id', $vote['id'])->first();

            if ($game) {
                Log::info("Hey, we have this game: " . $game->name);
                Rating::create([
                    'game_id' => $game->id,
                    'points' => $vote['points'],
                    'voted_at' => Carbon::now()->toDateString(),
                    'user_name' => $userName,
                    'email' => $email
                ]);
            } else {
                Log::info("Hey, we don't have this game.");
                $game = Game::create([
                    'bgg_id' => $vote['id'],
                    'name' => $vote['name'],
                ]);

                Rating::create([
                    'game_id' => $game->id,
                    'points' => $vote['points'],
                    'voted_at' => Carbon::now()->toDateString(),
                    'user_name' => $userName,
                    'email' => $email
                ]);
            }

            $game->score += $vote['points'];
            $game->save();
        }


        return response()->json(['message' => 'Vote submitted successfully']);
    }
}
