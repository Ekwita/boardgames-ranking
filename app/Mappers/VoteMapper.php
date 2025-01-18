<?php

namespace App\Mappers;

use App\Dtos\GameRateDto;
use App\Dtos\VoteDto;
use Carbon\Carbon;

class VoteMapper
{
    public function map(array $validated): VoteDto
    {
        $collection = collect($validated['votes'])->map(function ($vote) {
            return new GameRateDto(
                $vote['id'],
                $vote['name'],
                $vote['points'],
                $vote['image'] ?? null
            );
        });

        return new VoteDto(
            $validated['username'],
            $validated['email'],
            $collection,
            Carbon::now()->toDateString()
        );
    }
}