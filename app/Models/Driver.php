<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $table = 'drivers';
    protected $fillable = ['name', 'discord', 'country_code', 'team_number'];

    public function myteam()
    {
        return $this->hasOne(DriversTeams::class, 'driver_id', 'id')->with('team');
    }

    public function team_mate()
    {
        // return DriversTeams::query()->where('driver_id', $this->id)->get();
    }

    public function points()
    {
        return Point::query()->where('driver_id', $this->id)->sum('point');
    }

    public function tablePoints($track_id)
    {
        return Point::query()->where('driver_id', $this->id)->where('track_id', $track_id)->first()->point ?? 0;
    }
}
