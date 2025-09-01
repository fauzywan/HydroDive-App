<?php

namespace App\Livewire\Club;
use App\Models\ClubWaitingList;
use Livewire\Component;

class ClubMembership extends Component
{
    public $club;
    public function render()
    {
        $this->club=auth()->user()->club;
        $waitingList=(ClubWaitingList::where('club_id',$this->club->id)->orderBy('created_at','desc')->get());
        return view('livewire.club.club-membership',['waitingList'=>$waitingList]);
    }
    public function requestMembership(){
        if(ClubWaitingList::where('club_id',$this->club->id)->get()->count()>0){

        }else{

        }
        ClubWaitingList::create(['club_id'=>$this->club->id,"status"=>1,"message"=>"","Approver"=>""]);
        return $this->redirect('/club/membership',navigate:true);
    }
}
