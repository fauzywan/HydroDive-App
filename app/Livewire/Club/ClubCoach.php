<?php

namespace App\Livewire\Club;
use App\Models\Coach;
use App\Models\coachLicense;
use Flux\Flux;

use Livewire\Component;
use Livewire\WithPagination;

class ClubCoach extends Component
{
use WithPagination;
    public $first_name;
    public $searchCoach;
    public $coachSearch;
    public $id;
    public function delete($id)
    {
        $coach= Coach::find($id);
        $this->first_name=$coach->name;
        $this->id=$coach->id;
        Flux::modal('delete-profile')->show();
    }
    public function searchingCoach()
    {
        $this->coachSearch=Coach::where('name',"LIKE","%$this->searchCoach%")->where('club_id','!=',auth()->user()->club->id)->get();

    }
    public function recruitCoach($id=null)
    {
        if($id){
            $coach=Coach::find($id)->update(['club_id'=>auth()->user()->club->id]);
            return $this->redirect('/club/coach',navigate:true);
        }else{

            Flux::modal('search-coach')->show();
        }
    }
    public function updatingKeyword(){
        $this->gotoPage(1);
    }

    public function destroy()
    {


    $coach=Coach::where('id',$this->id)->first();
           if($coach->coach_category_id==2){
            $coach->club->update(['hoc'=>1]);
        }
        $coach->update(['club_id'=>1]);

           session()->flash('message', 'Data berhasil Dihapus');
           Flux::modal('delete-profile')->close();
        if(auth()->user()->role_id==5){

            return $this->redirect('/club/coach', navigate: true);
        }
        return $this->redirect('/coach',navigate:true);
    }
        public $coachName;
        public $coachEmail;
        public $coachGender;
        public $coachAddress;
        public $coachPhone;
        public $coachStatus;
    public function edit($id){
        return $this->redirect("/coach/$id/profile",navigate:true);
    }
    public function profile($id){
        $coach= Coach::find($id);
        $this->coachName=$coach->name;
        $this->coachEmail=$coach->email;
        $this->coachGender=$coach->gender;
        $this->coachAddress=$coach->address;
        $this->coachPhone=$coach->phone;
        $this->coachStatus=$coach->title;
        Flux::modal('profile-coach')->show();
    }
    public $keyword;
    public function render()
    {
        $coaches= \App\Models\Coach::where("id","!=",1)->where('club_id',auth()->user()->club->id)->paginate(5);
        if($this->keyword){
            $coaches= \App\Models\Coach::where("id","!=",1)->where('club_id',auth()->user()->club->id)->where('name','LIKE',"%$this->keyword%")->paginate(5);
        }
        return view('livewire.club.club-coach',[
            'coaches' => $coaches,
        ]);
    }

}
