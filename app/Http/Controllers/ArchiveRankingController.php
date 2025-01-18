<?php

namespace App\Http\Controllers;

use App\Services\Rankings\ArchiveRankingService;

class ArchiveRankingController
{
public function __construct(public ArchiveRankingService $archiveRankingService)
{}

    public function listArchivedRankings()
    {
        $podiaCollection = $this->archiveRankingService->archivePodia();

        return $podiaCollection;
    }
}
