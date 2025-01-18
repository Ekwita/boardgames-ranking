<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoteRequest;
use App\Mappers\VoteMapper;
use App\Services\RatingService;
use Illuminate\Http\JsonResponse;

class GameVoteController extends Controller
{

    public function __construct(
        protected RatingService $ratingService,
        protected VoteMapper $voteMapper,
    ) {}

    public function vote(VoteRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $voteDto = $this->voteMapper->map($validated);

        return $this->ratingService->handleVote($voteDto);
    }
}
