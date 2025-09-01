<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupAge extends Model
{
    protected $guarded=[];
    public function showName(){
        return "$this->name ($this->min_age - $this->max_age) Tahun";
    }
}
