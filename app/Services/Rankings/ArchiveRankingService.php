<?php

namespace App\Services\Rankings;

use App\Http\Resources\PodiumCollection;
use App\Models\Podium;

class ArchiveRankingService
{
    public function archivePodia(): PodiumCollection
    {
        $podiaList = $this->getPodiums();

        $podiaCollection = new PodiumCollection($podiaList);

        return $podiaCollection;
    }

    private function getPodiums()
    {
        return Podium::all();
    }
}
