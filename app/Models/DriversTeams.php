<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriversTeams extends Model
{
    use HasFactory;

    protected $table = 'drivers_teams';
    protected $fillable = ['driver_id','team_id'];


    public function team()
    {
        return $this->belongsTo(Team::class,'team_id','id');
    }


}
