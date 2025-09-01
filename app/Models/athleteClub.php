<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class athleteClub extends Model
{
    protected $guarded=[];
    public function athlete()
    {
        return $this->belongsTo(Athlete::class);
    }
    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
