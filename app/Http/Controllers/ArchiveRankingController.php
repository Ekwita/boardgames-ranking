<?php

namespace App\Http\Controllers;

use App\Http\Resources\PodiumCollection;
use App\Http\Resources\PodiumResource;
use App\Models\Podium;
use App\Services\Rankings\Interfaces\ArchiveRankingServiceInterface;

class ArchiveRankingController
{
    public function __construct(protected ArchiveRankingServiceInterface $archiveRankingService) {}

    public function listArchivedRankings(): PodiumCollection
    {
        $podiaCollection = $this->archiveRankingService->archivePodia();

        return $podiaCollection;
    }

    public function lastRankingPodium(): PodiumResource
    {
        $games = Podium::latest()->first();

        $podiaCollection = new PodiumResource($games);

        return $podiaCollection;
    }
}
