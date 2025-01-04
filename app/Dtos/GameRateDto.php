<?php

namespace App\Dtos;

class GameRateDto
{
    public function __construct(
        public string $id,
        public string $name,
        public int $points,
        public ?string $image,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'points' => $this->points,
            'image' => $this->image
        ];
    }
}
