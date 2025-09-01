<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventAdministration extends Model
{
    protected $guarded=[];
    public function branch(){
        return $this->belongsTo(EventBranch::class,'event_branch_id','id');
    }
    public function player(){
        return $this->hasOne(EventMatchPlayer::class,'administration_id','id');
    }
    public function club()
    {
        return $this->belongsTo(Club::class);
    }
    public function event()
    {
        return $this->belongsTo(Event::class,'event_id','id');
    }
    public function transaction()
    {
    return $this->hasMany(EventAdministrationTransaction::class, 'administration_id', 'id');
    }
    public function paymentMethod()
    {
    return $this->event->club->payment_methods;
    }
    public function athlete()
    {
        return $this->belongsTo(Athlete::class);
    }
}
