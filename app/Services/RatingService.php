<?php

namespace App\Services;

use App\Dtos\VoteDto;
use App\Repositories\GameRepository;
use App\Repositories\RatingReposiotry;
use App\Services\Ratings\RatingValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class RatingService
{
    public function __construct(
        protected RatingValidator $ratingValidator,
        protected GameRepository $gameRepository,
        protected RatingReposiotry $ratingReposiotry,
    ) {}

    public function handleVote(VoteDto $voteDto): JsonResponse
    {
        $this->ratingValidator->validateVoteExists($voteDto);


        foreach ($voteDto->gamesRating as $gameRateDto) {

            $game = $this->gameRepository->findOrCreateGame($gameRateDto);
            Log::info('Game selected');

            $this->ratingReposiotry->createRating($game, $voteDto, $gameRateDto);
            Log::info('Rating created');

            $this->gameRepository->updateGameScore($game, $gameRateDto);
            Log::info('Game score updated');

            Log::info("Vote recorded for game: {$game->name}, points: {$gameRateDto->points}");
        }


        return response()->json(['message' => 'Vote submitted successfully']);
    }
}
