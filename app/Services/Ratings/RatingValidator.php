<?php

namespace App\Services\Ratings;

use App\Dtos\VoteDto;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;

class RatingValidator
{
    public function validateVoteExists(VoteDto $voteDto): void
    {
        $existingVotes = Rating::where('email', $voteDto->email)
            ->whereYear('voted_at', Carbon::now()->year)
            ->whereMonth('voted_at', Carbon::now()->month)
            ->exists();

        if ($existingVotes) {
            throw new HttpResponseException(
                response()->json(['message' => 'You have already voted this month'], 403)
            );
        }
    }
}
