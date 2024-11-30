<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GameController extends Controller
{
    public function search(Request $request)
    {
        $searchQuery = $request->query('search');

        if (!$searchQuery) {
            return response()->json([
                'error' => 'Search query is required'
            ], 400);
        }

        $url = "https://boardgamegeek.com/xmlapi/search?search=" . urlencode($searchQuery);
        $response = Http::get($url);

        try {

            if (!$response->successful()) {
                return response()->json([
                    'error' => 'Failed to fetch data from BoardGameGeek API'
                ], 500);
            }

            $xml = simplexml_load_string($response->body());
            $games = [];

            foreach ($xml->boardgame as $game) {
                $games[] = [
                    'id' => (string) $game['objectid'],
                    'name' => (string) $game->name,
                ];
            }

            return response()->json($games, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}
