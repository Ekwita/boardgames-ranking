<?php

namespace App\Http\Controllers;

use App\Dtos\GameRateDto;
use App\Dtos\VoteDto;
use App\Http\Requests\VoteRequest;
use App\Services\RatingService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class RatingController extends Controller
{

    public function __construct(
        protected RatingService $ratingService,
    ) {}

    public function vote(VoteRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $collection = collect($validated['votes'])->map(function ($vote) {
            return new GameRateDto(
                $vote['id'],
                $vote['name'],
                $vote['points'],

            );
        });

        $voteDto = new VoteDto(
            $validated['username'],
            $validated['email'],
            $collection,
            Carbon::now()->toDateString()
        );

        return $this->ratingService->handleVote($voteDto);
    }
}
