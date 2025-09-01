<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerTime extends Model
{
protected $fillable = [
    'player_id', 'start_time', 'finish_time', 'duration'
];
}
