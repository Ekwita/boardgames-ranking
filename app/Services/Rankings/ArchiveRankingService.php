<?php

namespace App\Services\Rankings;

use App\Http\Resources\PodiumCollection;
use App\Models\Podium;
use App\Services\Rankings\Interfaces\ArchiveRankingServiceInterface;
use Illuminate\Support\Collection;

class ArchiveRankingService implements ArchiveRankingServiceInterface
{
    public function archivePodia(): PodiumCollection
    {
        $podiaList = $this->getPodiums();

        $podiaCollection = new PodiumCollection($podiaList);

        return $podiaCollection;
    }

    private function getPodiums(): Collection
    {
        return Podium::all();
    }
}
