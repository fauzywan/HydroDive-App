<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $guarded=[];
    public function registered()
    {
        return $this->hasMany(EventClub::class,'club_id','id');
    }
    public function events()
    {
        return $this->hasMany(EventClub::class);
    }
    public function payment_methods()
    {
    return $this->hasMany(PaymentMethodClub::class);
    }

    public function type()
    {
        return $this->belongsTo(ClubType::class,'type_id','id');
    }
    public function register_fee()
    {
        return $this->hasOne(ClubRegistrationFee::class,'club_id','id');
    }

    public function athletess()
    {
        return $this->belongsToMany(Athlete::class, 'athlete_clubs', 'club_id', 'athlete_id')
                ->wherePivot('status', 1);
}
    public function athletes()
    {
        return $this->hasMany(Athlete::class);
    }
    public function coaches()
    {
        return $this->hasMany(Coach::class);
    }
    public function head()
    {
        return $this->belongsTo(Coach::class,'hoc','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function waitingList()
    {
        return $this->hasMany(ClubWaitingList::class);
    }
}
