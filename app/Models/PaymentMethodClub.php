<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodClub extends Model
{
    protected $guarded=[];
    public function pm(){
        return $this->belongsTo(PaymentMethod::class,'payment_method_id','id');
    }
    public function name(){
        return $this->pm->name;
    }


}
