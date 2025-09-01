<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryLeaderboard extends Model
{
    protected $guarded = [];

    public function athlete()
    {
        return $this->belongsTo(Athlete::class, 'athlete_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function club()
    {
        return $this->belongsTo(Club::class, 'club_id', 'id');
    }
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
    public function player()
    {
        return $this->belongsTo(EventMatchPlayer::class, 'event_match_player_id', 'id');
    }

}
