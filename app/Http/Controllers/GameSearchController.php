<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GameSearchController
{
    public function search(Request $request)
    {
        $query = $request->query('search', '');

        if (empty($query)) {
            return response()->json([
                'error' => 'Query parameter "search" is required.'
            ], 400);
        }

        $games = $this->fetchSearchResults($query);

        if (empty($games)) {
            return response()->json([
                'error' => 'No games found or failed to fetch data.'
            ], 500);
        }

        $games = $this->fetchGameDetails($games);

        return response()->json(array_values($games));
    }

    private function fetchSearchResults(string $query): array
    {
        return Cache::remember("search_results_{$query}", 3600, function () use ($query) {
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
        });
    }

    private function fetchGameDetails(array $games): array
    {
        $gameIds = array_keys($games);

        $requests = Http::pool(function ($pool) use ($gameIds) {
            return array_map(function ($gameId) use ($pool) {
                return $pool->get("https://boardgamegeek.com/xmlapi2/thing?id={$gameId}");
            }, $gameIds);
        });

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
}
