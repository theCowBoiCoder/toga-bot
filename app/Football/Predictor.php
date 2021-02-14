<?php

namespace App\Football;

use App\Models\GamePredictor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Predictor {

    /**
     * Set the Result for a match
     * @param $match_id
     * @param $discord_id
     * @param $score
     * @return Builder|Model
     */
    public static function setMatchPrediction($match_id, $discord_id, $score)
    {
        return GamePredictor::query()->updateOrCreate([
            'discord_id' => $discord_id,
            'match_id' => $match_id
        ],[
            'result' => $score
        ]);
    }

    /**
     * Gets My Match Predictions
     * @param $discord_id
     * @param $match_ids
     * @return Builder[]|Collection
     */
    public static function getMyMatchPredictions($discord_id, $match_ids)
    {
        return GamePredictor::query()
            ->where('discord_id',$discord_id)
            ->whereIn('match_id',$match_ids)->get();
    }
}
