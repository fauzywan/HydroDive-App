<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventNumber extends Model
{
    protected $guarded=[];
     public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');

    }
     public function branches()
    {
        return $this->hasMany(EventBranch::class);

    }
     public function event()
    {
        return $this->belongsTo(Event::class,"event_id",'id');

    }

}
