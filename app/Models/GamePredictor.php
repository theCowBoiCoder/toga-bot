<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GamePredictor extends Model
{
    use HasFactory;

    protected $table = 'game_predictors';

    protected $fillable = [
        'match_id',
        'result',
        'discord_id',
        'is_winner'
    ];
}
