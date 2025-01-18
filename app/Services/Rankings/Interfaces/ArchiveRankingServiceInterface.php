<?php

namespace App\Services\Rankings\Interfaces;

use App\Http\Resources\PodiumCollection;

interface ArchiveRankingServiceInterface
{
    public function archivePodia(): PodiumCollection;
}