<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameCollection;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GameController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->query('search', '');

        if (empty($query)) {
            return response()->json([
                'error' => 'Query parameter "search" is required.'
            ], 400);
        }

        // Pobierz wyniki wyszukiwania
        $games = $this->fetchSearchResults($query);

        if (empty($games)) {
            return response()->json([
                'error' => 'No games found or failed to fetch data.'
            ], 500);
        }

        // Pobierz szczegóły gier równolegle
        $games = $this->fetchGameDetails($games);

        return response()->json(array_values($games));
    }

    private function fetchSearchResults(string $query): array
    {
        $response = Http::get("https://boardgamegeek.com/xmlapi2/search?query={$query}&type=boardgame");

        if ($response->failed()) {
            return [];
        }

        $xml = simplexml_load_string($response->body());
        $games = [];

        foreach ($xml->item as $item) {
            $gameId = $item['id'] ?? null;
            $name = $item->name['value'] ?? null;
            $yearPublished = $item->yearpublished['value'] ?? null;

            if ($gameId && $name) {
                $games[(string) $gameId] = [
                    'id' => (string) $gameId,
                    'name' => (string) $name,
                    'year' => $yearPublished ? (string) $yearPublished : null,
                ];
            }
        }

        return $games;
    }

    private function fetchGameDetails(array $games): array
    {
        $gameIds = array_keys($games);

        // Wykonaj równoległe zapytania
        $requests = Http::pool(function ($pool) use ($gameIds) {
            return array_map(function ($gameId) use ($pool) {
                return $pool->get("https://boardgamegeek.com/xmlapi2/thing?id={$gameId}");
            }, $gameIds);
        });

        // Przetwarzanie odpowiedzi
        foreach ($requests as $key => $response) {
            if ($response->successful()) {
                $detailXml = simplexml_load_string($response->body());
                $detail = $detailXml->item;

                if ($detail) {
                    $thumbnail = $detail->image ?? null;
                    if ($thumbnail) {
                        $games[$gameIds[$key]]['image'] = (string) $thumbnail;
                    }
                }
            }
        }

        return $games;
    }

    public function getBestGames(): GameCollection
    {

        $topScores = Game::orderBy('score', 'desc')
            ->distinct()
            ->limit(5)
            ->pluck('score');

        $topGames = Game::whereIn('score', $topScores)
            ->orderBy('score', 'desc')
            ->limit(5)
            ->get();

        return new GameCollection($topGames);
    }
}
