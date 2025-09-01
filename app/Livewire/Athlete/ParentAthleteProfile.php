<?php

namespace App\Livewire\Athlete;

use Livewire\Component;

class ParentAthleteProfile extends Component
{
    public $parent;
    public $athlete;
    public function render()
    {
        $this->parent= auth()->user()->parent;
        $this->athlete=$this->parent->athlete;
        return view('livewire.athlete.parent-athlete-profile');
    }
}
