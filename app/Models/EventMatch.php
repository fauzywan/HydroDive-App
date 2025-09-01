<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventMatch extends Model
{
    protected $guarded=[];
    public function players()
    {
        return $this->player();
    }

    public function player()
    {
        return $this->hasMany(EventMatchPlayer::class);
    }
    public function Heat()
    {
        return $this->belongsTo(EventHeat::class,'heat_id','id');
    }
}
