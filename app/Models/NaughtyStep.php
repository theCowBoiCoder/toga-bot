<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NaughtyStep extends Model
{
    use HasFactory;

    protected $table = 'naughty_steps';
    protected $fillable = ['user_id', 'role_ids', 'is_active'];
}
