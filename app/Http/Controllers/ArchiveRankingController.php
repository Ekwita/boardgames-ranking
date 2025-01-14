<?php

namespace App\Http\Controllers;

use App\Http\Resources\PodiumCollection;
use App\Http\Resources\PodiumResource;
use App\Models\Podium;

class ArchiveRankingController
{
    public function listArchivedRankings()
    {
        $podiaList = Podium::all();

        $podiaCollection = new PodiumCollection($podiaList);

        return $podiaCollection;
    }
    public function getArchiveRankingByMonth(): PodiumResource
    {
        return PodiumResource::make(Podium::find(1));
    }
}
