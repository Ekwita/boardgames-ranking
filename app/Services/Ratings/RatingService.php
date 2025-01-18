<?php

namespace App\Services\Ratings;

use App\Dtos\VoteDto;
use App\Repositories\Interfaces\GameRepositoryInterface;
use App\Repositories\Interfaces\RatingRepositoryInterface;
use App\Services\Ratings\Interfaces\RatingServiceInterface;
use App\Services\Ratings\RatingValidator;
use Illuminate\Http\JsonResponse;

class RatingService implements RatingServiceInterface
{
    public function __construct(
        protected RatingValidator $ratingValidator,
        protected GameRepositoryInterface $gameRepository,
        protected RatingRepositoryInterface $ratingReposiotry,
    ) {}

    public function handleVote(VoteDto $voteDto): JsonResponse
    {
        $this->ratingValidator->validateVoteExists($voteDto);


        foreach ($voteDto->gamesRating as $gameRateDto) {

            $game = $this->gameRepository->findOrCreateGame($gameRateDto);

            $this->ratingReposiotry->createRating($game, $voteDto, $gameRateDto);

            $this->gameRepository->updateGameScore($game, $gameRateDto);
        }


        return response()->json(['message' => 'Vote submitted successfully']);
    }
}
