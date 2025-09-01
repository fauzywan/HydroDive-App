<?php

namespace App\Models;

use Carbon\Carbon as CarbonCarbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Athlete extends Model
{

    use HasFactory;
    protected $guarded=[];
    public function historyTime(){
        return $this->hasMany(EventMatchPlayer::class);
    }
    public function getAge(){
        return CarbonCarbon::parse($this->dob)->age;
    }
    public function name(){
        return $this->first_name." ".$this->last_name;
    }
    public function fee(){
       return $this->hasMany(RegistrationFee::class);
    }
    public function age(){
        return Carbon::parse($this->dob)->age;
    }
    public function clubs()
    {
        return $this->hasMany(athleteClub::class);
    }
    public function administration()
    {
        return $this->hasMany(EventAdministration::class);
    }
    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
