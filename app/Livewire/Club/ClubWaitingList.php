<?php

namespace App\Livewire\Club;

use App\Models\Athlete;
use App\Models\athleteClub;
use App\Models\ClubWaitingList as waitingList;
use App\Models\Club;
use App\Models\Coach;
use Flux\Flux;
use Livewire\Component;

class ClubWaitingList extends Component
{
    public $message;
    public $approval=1;
    public $selectClub=1;
    public $logo;
    public $clubName;
    public $clubOwner;
    public $clubAddress;
    public $clubPool;
    public $clubHOC;
    public $first_name;
    public $clubMember;
    public $clubPayment;
    public $clubEmail;
    public $clubLogo;
    public $waitingId;
    public function rejectedClub(){
        $this->selectClub=$this->approval;
    }
    public $waitingCount;
    public function render()
    {

        $this->waitingCount=waitingList::where('status','!=',0)->where('status','!=',2)->orderBy('created_at','desc')->count();
        $waitingList=waitingList::where('status','!=',0)->where('status','!=',2)->orderBy('created_at','desc')->paginate(5);

        return view('livewire.club.club-waiting-list',['waitingList'=>$waitingList]);
    }
    public function save()
    {

        $wl=waitingList::find($this->waitingId);
        $status=2;
        if($this->approval==1){
            $status=0;
            Club::find($wl->club_id)->update(['status'=>1]);
        }
        $wl->update(['status'=>$status,'approver'=>auth()->user()->name,"message"=>$this->message]);
        session()->flash('message', 'Data berhasil Diubah');
    return $this->redirect('/club/waiting-list', navigate:true);
    }
    public function confirm($id)
    {

        $this->waitingId=$id;
        $wl=waitingList::find($id);
        $club=Club::find($wl->club_id);
        $this->clubName=$club->name."($club->nick)";
        $this->clubOwner=$club->owner;
        $this->clubAddress=$club->address;
        $this->clubEmail=$club->email;
        $this->clubPayment=$club->register_fee->status;
        $this->clubMember=athleteClub::where('status',1)->where('club_id',$wl->club_id)->count();
        $this->clubHOC=Coach::find($club->hoc)->name;
        $this->clubLogo=$club->logo;
        $poolStatus=['owned','rented','public_pool'];

        $this->clubPool=$club->homebase."(".$poolStatus[intval($club->pool_status)].")";
        Flux::modal('delete-profile')->show();
    }
    public $formStage=0;
    public $nextButton="Next";
    public $prevButton="Back";
    public $photoPrev='';
    public function prevForm(){
        if($this->formStage>0){
        $this->formStage-=1;
        $this->nextButton="Next";
        }
    }
    public function nextForm(){
        if($this->formStage<=0){
            $this->formStage+=1;
            $this->nextButton="Next";
        }
        if($this->formStage==1){
            $this->prevButton="Back";
            $this->nextButton="confirm";
        }

    }
}
