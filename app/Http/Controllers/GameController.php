<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GameController extends Controller
{
    public function search(Request $request)
    {
        // Pobieramy zapytanie `search` z parametru GET
        $query = $request->query('search', '');

        // Walidacja, czy zapytanie nie jest puste
        if (empty($query)) {
            return response()->json([
                'error' => 'Query parameter "search" is required.'
            ], 400);
        }

        // Wykonanie zapytania do API BGG
        $response = Http::get("https://boardgamegeek.com/xmlapi2/search?query={$query}");

        // Sprawdzenie, czy API zwróciło poprawną odpowiedź
        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to fetch data from BGG API.'
            ], 500);
        }

        // Parsowanie XML do tablicy
        $xml = simplexml_load_string($response->body());

        // Transformacja danych z XML do JSON
        $games = [];
        foreach ($xml->item as $item) {
            $name = $item->name['value'] ?? null;
            $yearPublished = $item->yearpublished['value'] ?? null;
            if ($name) {
                $games[] = [
                    'id' => (string) $item['id'],
                    'name' => (string) $name,
                    'year' => $yearPublished ? (string) $yearPublished : null,
                ];
            }
        }

        // Zwracamy dane jako JSON
        return response()->json($games);
    }
}
