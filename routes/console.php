<?php

use App\Actions\MonthlyRankingResultAction;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(
    new MonthlyRankingResultAction
)->monthly();


Artisan::command('monthly-ranking', function () {
    app(MonthlyRankingResultAction::class)();
    $this->info('Monthly ranking has been successfully processed.');
})->purpose('Create a new monthly ranking');
