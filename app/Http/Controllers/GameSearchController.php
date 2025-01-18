<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\SearchGameServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class GameSearchController
{

    public function __construct(public SearchGameServiceInterface $game) {}

    public function search(Request $request): JsonResponse
    {
        $query = $request->query('search', '');

        $searchedGames = $this->game->searchGameByQuery($query);

        return $searchedGames;
    }
}
