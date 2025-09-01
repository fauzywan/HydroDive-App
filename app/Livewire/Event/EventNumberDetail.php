<?php

namespace App\Livewire\Event;

use App\Models\EventHeat;
use App\Models\EventMatch;
use App\Models\EventMatchPlayer;
use Livewire\Component;

class EventNumberDetail extends Component
{

    public $athletes=[];
    public $matches=[];
    public $heat;
    public $page='list-heat';
    public function startStopWatch($id)
    {
        $athlete_id=$id;
        $branch_id=$this->heat->branch_id;
    return $this->redirect("/stopwatch/$id/$branch_id/show-menu",navigate:true);
    }
    public function mount($id)
    {
            $this->page=request()->segment(3);

        $this->heat=  EventHeat::find($id);
        if($this->page=="list-heat"){
            $this->athletes=$this->heat->players;
        if($this->heat->branch->administration->count()>0){
            $match=EventMatch::where('heat_id',1)->where('status',1)->first();
            if($match){
             $this->athletes=   $this->heat->branch->administration->filter(function ($a) use ($match) {
             return $match->player->where('administration_id', $a->id)->count()==0;
            });
        }
    }

    }else{
        $this->matches= EventMatch::where('heat_id',$id)->where('status',1)->get();
    }

    // $this->athletes=Athlete::all();
    }
    public function deletePlayer($id)
    {
        EventMatchPlayer::find($id)->delete();
        session()->flash('message','Data Berhasil Dihapus');
    }

    public function render()
    {

        return view('livewire.event.event-number-detail');
    }
}
