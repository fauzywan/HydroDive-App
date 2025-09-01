<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    protected $guarded=[];

    public function account(){
        return $this->belongsTo(User::class,'email','email');
    }
    public function club(){
       return $this->belongsTo(Club::class,'club_id','id');
    }
    public function title(){
       return $this->belongsTo(CoachCategory::class,'coach_category_id','id');
    }
    public function licenses()
    {
        return $this->hasMany(coachLicense::class);

    }
}
