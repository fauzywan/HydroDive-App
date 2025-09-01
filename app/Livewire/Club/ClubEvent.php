<?php

namespace App\Livewire\Club;

use Livewire\Component;

class ClubEvent extends Component
{
    public $club;
    public $events;
    public function mount($club)
    {
        $this->club = auth()->user()->club;
    }
    public function render()
    {

        $this->events = \App\Models\Event::where('status','!=',0)->get();
        return view('livewire.club.club-event');
    }
}
