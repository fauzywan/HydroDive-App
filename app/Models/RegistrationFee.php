<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationFee extends Model
{
    protected $guarded=[];
    public function athlete(){
        return $this->belongsTo(Athlete::class);
    }
}
