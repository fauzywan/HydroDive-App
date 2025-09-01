<?php

namespace App\Livewire\Match;

use App\Models\EventHeat;
use App\Models\EventMatch;
use App\Models\EventMatchPlayer;
use Livewire\Component;
use Illuminate\Routing\Redirector;
class MatchIndex extends Component
{
     public $athletes=[];
    public $matches=[];
    public $heat;
    public $evenNumberId;
    public $page='list';
    public $navigations;
    public $navActive=1;

    public function startStopWatch($id)
    {
        $athlete_id=$id;
        $branch_id=$this->heat->branch_id;
        return $this->redirect("/stopwatch/$id/$branch_id/show-menu",navigate:true);
    }
    public function mount($id)
    {
        $this->page=request()->segment(3);
    $this->navActive=2;

        $this->heat=  EventHeat::find($id);
        $this->evenNumberId=$this->heat->branch->event_number_id;
        if($this->page=="player"){
            $this->athletes=$this->heat->players;
            if($this->heat->branch->administration->count()>0){
                $match=EventMatch::where('heat_id',$id)->where('status',1)->first();
            if($match){
                $this->athletes= $this->heat->branch->administration->filter(function ($a) use ($match) {
             return $match->player->where('administration_id', $a->id)->count()==0;
            });
        }
    }

}else{
    $this->navActive=1;
    $this->matches= EventMatch::where('heat_id',$id)->where('status',1)->get();
}

// $this->athletes=Athlete::all();
     $this->navigations=[
            ["no"=>1,"name"=>"Pertandingan","href"=>'list'],
            ["no"=>2,"name"=>"Pemain","href"=>'player'],
        ];

}
public function show($no)
{
$this->navActive=$no;
}
public function deletePlayer($id)
    {
        EventMatchPlayer::find($id)->delete();
        session()->flash('message','Data Berhasil Dihapus');
    }

public function backToLeft(Redirector $redirector)
{
    $targetUrl = "/number/{$this->evenNumberId}/list-heat";
    if ($redirector->back()->getTargetUrl() === url($targetUrl)) {
        return $this->redirect($redirector->back()->getTargetUrl(), navigate: true);
    }

    return $this->redirect($targetUrl, navigate: true);
}
    public function render()
    {
        return view('livewire.match.match-index');
    }
}
