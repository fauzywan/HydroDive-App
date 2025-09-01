<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventHeat extends Model
{
    protected $guarded=[];
    public function branch()
    {
        return $this->belongsTo(EventBranch::class);
    }
    public function eventName()
    {
        return $this->branch->eventNumber->number.": ".$this->branch->eventNumber->category->description;
    }
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function players()
    {
        return $this->hasMany(EventMatchPlayer::class,'event_match_id','id');
    }
    public function ActiveMatch()
    {
        return $this->hasMany(EventMatch::class,'heat_id','id');
    }
    public function matches()
    {
        return $this->hasMany(EventMatch::class,'heat_id','id');
    }

}
