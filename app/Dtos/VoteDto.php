<?php

namespace App\Dtos;

use Illuminate\Support\Collection;

class VoteDto
{

    public function __construct(
        public string $userName,
        public string $email,
        public Collection $gamesRating,
        public string $votedAt,
    ) {}

    public function toArray(): array
    {
        return [
            'username' => $this->userName,
            'email' => $this->email,
            'voted_at' => $this->votedAt,
        ];
    }
}
