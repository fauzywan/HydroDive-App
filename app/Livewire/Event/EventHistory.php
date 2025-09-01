<?php

namespace App\Livewire\Event;

use App\Models\Event;
use App\Models\EventDate;
use Livewire\Component;

class EventHistory extends Component
{
    public $eventYears;
    public $yearSelect;
    public function mount()

    {
              $this->eventYears  = EventDate::distinct()->pluck('competition_start')->map(function ($date) {
            return \Carbon\Carbon::parse($date)->year;
        })->unique();;
        
    }
     public function updatedYearSelect($value)
    {
    }

    public function render()
    {
        $events=[];
 
        if(!$this->eventYears->isEmpty()){
            $this->yearSelect = $this->eventYears->first();
            $events=Event::whereYear('competition_start',$this->yearSelect)->get();
        }
        return view('livewire.event.event-history',['eventYears'=>$this->eventYears,'events'=>$events]);
    }
    public function detailHistory($id)
    {
        return $this->redirect("/history/$this->yearSelect/$id/detail", navigate: true);
    }
}
