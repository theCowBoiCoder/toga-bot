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

    /**
     * Returns the match
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function match(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Result::class,'id','match_id');
    }
}
