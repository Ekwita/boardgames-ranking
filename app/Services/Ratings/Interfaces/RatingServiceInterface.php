<?php

namespace App\Services\Ratings\Interfaces;

use App\Dtos\VoteDto;
use Illuminate\Http\JsonResponse;

interface RatingServiceInterface
{
    public function handleVote(VoteDto $voteDto): JsonResponse;
}