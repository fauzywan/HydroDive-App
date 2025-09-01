<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClubSchedule extends Model
{
  protected $guarded=[];
  public function getDay(){
    $number=$this->day;
    if ($number == 1) {
        return "Monday";
    }

    if ($number == 2) {
        return "Tuesday";
    }

    if ($number == 3) {
        return "Wednesday";
    }

    if ($number == 4) {
        return "Thursday";
    }

    if ($number == 5) {
        return "Friday";
    }

    if ($number == 6) {
        return "Saturday";
    }

    if ($number == 7) {
        return "Sunday";
    }


  }
}
