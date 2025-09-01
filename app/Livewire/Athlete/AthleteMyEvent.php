<?php
namespace App\Livewire\Athlete;

use App\Models\Athlete;
use App\Models\EventAdministration;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AthleteMyEvent extends Component
{
    public $myEvents = [];

    public function mount()
    {

        $athleteId = Auth::user()->id; // pastikan user yang login adalah atlet
        $this->myEvents = EventAdministration::where('athlete_id',auth()->user()->athlete->id)
            ->get();
    }

    public function render()
    {
        return view('livewire.athlete.athlete-my-event', [
            'eventAdministrations' => $this->myEvents
        ]);
    }
}
