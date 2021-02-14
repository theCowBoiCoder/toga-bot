<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;
    protected $table = 'results';

    protected $fillable = [
        'match_id',
        'match_day',
        'comp',
        'status',
        'winner',
        'home_team_name',
        'home_team_score',
        'away_team_name',
        'away_team_score',
    ];
}
