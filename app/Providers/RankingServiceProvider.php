<?php

namespace App\Providers;

use App\Services\Rankings\ArchiveRankingService;
use App\Services\Rankings\CurrentRankingService;
use App\Services\Rankings\Interfaces\ArchiveRankingServiceInterface;
use App\Services\Rankings\Interfaces\CurrentRankingServiceInterface;
use Illuminate\Support\ServiceProvider;

class RankingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ArchiveRankingServiceInterface::class, ArchiveRankingService::class);
        $this->app->bind(CurrentRankingServiceInterface::class, CurrentRankingService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
