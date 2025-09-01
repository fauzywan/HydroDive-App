<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoachCategory extends Model
{
    protected $guarded=[];
    public function coach(){
        return $this->hasMany(Coach::class);
    }
}
