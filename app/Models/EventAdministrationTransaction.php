<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventAdministrationTransaction extends Model
{
    protected $guarded=[];
    public function administration()
    {
        return $this->belongsTo(EventAdministration::class, 'administration_id', 'id');
    }
}
