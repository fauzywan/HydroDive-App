<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AthleteParent extends Model
{
    protected $guarded=[];
    public function athlete(){
        return $this->belongsTo(Athlete::class,'athlete_id','id');
    }
}
