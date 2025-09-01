<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClubRegistrationFee extends Model
{
    protected $guarded=[];
    public function club(){
        return $this->belongsTo(Club::class);
    }
}
