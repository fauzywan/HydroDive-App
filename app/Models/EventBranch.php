<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EventBranch extends Model
{
    protected $guarded=[];
public function eventNumber()
{
    return $this->belongsTo(EventNumber::class,'event_number_id','id');
}


public function heats()
{
    return $this->hasMany(EventHeat::class,'branch_id','id');
}

public function event()
{
    return $this->eventNumber->event;
}

    public function administrationPay()
    {
        return "Rp".number_format($this->administration->where('status',1)->sum('fee'),0);

    }

    public function age()
    {
        return $this->belongsTo(GroupAge::class,'group_age_id','id');
    }
    public function groupAge()
    {
        // return $this->age->min_age." - ".$this->age->max_age;
        $referenceYear = Carbon::createFromDate(now()->year, 1, 1);
        $minYear = $referenceYear->copy()->subYears($this->age->max_age)->year;
        $maxYear = $referenceYear->copy()->subYears($this->age->min_age)->year;

        return $minYear . " - " . $maxYear;
    }
    public function kuota()
    {
        $kuota= $this->administration->where('club_id',auth()->user()->club->id)->count()?? 0;
        $kuota.="/".$this->capacity_per_club;
        return $kuota;
    }
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function administration()
    {
        return $this->hasMany(EventAdministration::class,'event_branch_id','id');
    }


}
