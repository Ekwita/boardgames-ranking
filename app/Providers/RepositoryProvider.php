<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Interfaces\GameRepositoryInterface::class,
            \App\Repositories\GameRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\RatingRepositoryInterface::class,
            \App\Repositories\RatingRepository::class
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
