<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventMatchPlayer extends Model
{
    protected $guarded=[];
        public function administration()
    {
        return $this->belongsTo(EventAdministration::class,'administration_id','id');
    }
        public function athlete()
    {
        return $this->belongsTo(Athlete::class);
    }
        public function match()
    {
        return $this->belongsTo(EventMatch::class,'event_match_id','id');
    }
}
