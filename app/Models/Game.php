<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    protected $fillable = [
        'bgg_id',
        'name',
        'hyperlink',
        'score',
        'image',
        'votes'
    ];

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }
}
