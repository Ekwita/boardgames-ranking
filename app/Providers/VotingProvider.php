<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class VotingProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            'App\Services\Interfaces\SearchGameServiceInterface',
            'App\Services\Games\SearchGameService'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
