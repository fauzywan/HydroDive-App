<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AthleteMigrationClub extends Model
{
    protected $guarded=[];
    public function clubsMigration()
    {
        return $this->oldClub->name ." -> ". $this->newClub->name;
    }
    public function athlete()
    {
        return $this->belongsTo(Athlete::class,'athlete_id','id');
    }
    public function oldClub()
    {
        return $this->belongsTo(Club::class,'old_club','id');
    }
    public function newClub()
    {
        return $this->belongsTo(Club::class,'new_club','id');
    }
}
