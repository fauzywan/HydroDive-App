<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClubRegistrationTransaction extends Model
{
    protected $guarded=[];

    public function clubRegistrationFee(){
        return $this->belongsTo(ClubRegistrationFee::class);
    }

}
