<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];
    public function sessions()
    {
        return $this->hasMany(EventHeat::class);
    }
    public function registered()
    {
        return $this->hasMany(EventClub::class);

    }
    public function dates()
    {
        return $this->hasMany(EventDate::class);

    }
    public function numbers()
    {
        return $this->hasMany(EventNumber::class);

    }
    public function branches()
    {
       return $this->hasManyThrough(
        \App\Models\EventBranch::class,
        \App\Models\EventNumber::class,
        'event_id',
        'event_number_id',
        'id',
        'id'
    );
    }
    public function club()
    {
        return $this->belongsTo(Club::class);

    }
    public function administration()
    {
        return $this->hasMany(EventAdministration::class);

    }
}
