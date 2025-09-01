<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventClub extends Model
{
    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }


}
