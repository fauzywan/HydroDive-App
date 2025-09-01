<?php

namespace App\Livewire\Club;

use App\Models\Athlete;
use App\Models\athleteClub;
use App\Models\Club;
use App\Models\RegistrationFee;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.user')]
class ClubAthlete extends Component
{
    use WithPagination;
    public $searchAthlete;
    public $athleteSearch;

    public $registration_fee;
    public $athlete;
    public $athleteId;
    public $keyword;
    public $first_name;
    public $searchBy="name";
public function addAthleteWithFee(){
    if(RegistrationFee::where('athlete_id',$this->athlete->id)->where('club_id',$this->club->id)->count()>0){
                $this->athlete->update(['club_id'=>$this->club->id,'status'=>1]);
                $this->athlete->club->update(['number_of_members'=>athleteClub::where('club_id',$this->club->id)->where('status',1)->count()]);
                session()->flash('message', 'Athlete Telah diaktifkan');
                return $this->redirect('/club/athlete',navigate:true);
            }
        if($this->registration_fee==0){
            $status=1;
        }else{
            $status=0;
        }
        $this->athlete->update(['club_id'=>$this->club->id,'status'=>$status]);
        $this->athlete->club->update(['number_of_members'=>Athlete::where('club_id',$this->club->id)->count()]);
        $paid=0;
        if($this->registration_fee==0){
            $paid=1;
        }
        RegistrationFee::create(['athlete_id'=>$this->athlete->id,'club_id'=>$this->club->id,'amount'=>$this->registration_fee,'remaining_amount'=>$this->registration_fee,'paid'=>$paid]);
        return $this->redirect('/club/athlete',navigate:true);
    }
   public function activeAthlete($id){
         $this->registration_fee=$this->club->registration_fee;
            $this->athlete=Athlete::find($id);

            Flux::modal('modal-fee')->show();
   }

    public function recruitAthlete($id=null)
    {
        if($id){
            $this->registration_fee=$this->club->registration_fee;
            $this->athlete=Athlete::find($id);
            dd($this->athlete);
            if(RegistrationFee::where('athlete_id',$this->athlete->id)->where('club_id',$this->club->id)->count()>0){
                $this->modalDelete=2;
                Flux::modal('delete-profile')->show();
            }else{

                Flux::modal('modal-fee')->show();
            }

        }else{

            Flux::modal('search-athlete')->show();
        }
    }
    public function searchingAthlete()
    {
        $this->athleteSearch=Athlete::where('first_name',"LIKE","%$this->searchAthlete%")->where('last_name',"LIKE","%$this->searchAthlete%")->get();
        $this->athleteSearch=$this->athleteSearch->filter(function($a){
            if($a->clubs->count()>0){
                return $a->clubs->where('status',1)->count()==0;
            }
            return $a->clubs->count()==0;
        });
    }
    public function setRegistrationFee()
    {
            if($this->nominal){

                $this->club->update(['registration_fee'=>$this->nominal]);
                session()->flash('message', 'Data berhasil Diubah');
            }else{
                session()->flash('message', 'Data gagal Diubah');
            }
        }
        public function nonaktifAthlete($id){
            $this->athlete=Athlete::find($id);
            $this->athleteId=$id;
            $this->first_name=$this->athlete->first_name;
            $this->modalDelete=3;
            Flux::modal('delete-profile')->show();
        }
        public function nonaktifAthleteProcess(){
            $this->athlete->update(['status'=>0]);
            session()->flash('message', 'Data berhasil Dihapus');
            return $this->redirect('/club/athlete',navigate:true);
        }
        public function delete($id){
            $this->athlete=Athlete::findorfail($id);
            $this->athleteId=$id;
            $this->first_name=$this->athlete->first_name;
            Flux::modal('delete-modal')->show();
            $this->modalDelete=1;
    }
    public $modalDelete=1;
    public function destroy(){

        if( RegistrationFee::where('athlete_id',$this->athlete->id)->where('club_id',$this->club->id)->count()>0){

            RegistrationFee::where('athlete_id',$this->athlete->id)->where('club_id',$this->club->id)->delete();
        }

        $athlete=Athlete::find($this->athleteId);
        $club_id=$athlete->club_id;
        $athlete->club->update(['number_of_members'=>Athlete::where('club_id',$club_id)->count()-1]);
        $athlete->update(['club_id'=>1]);
        session()->flash('message', 'Data berhasil Dihapus');

    }

    public $formShow=1;
    public function show($no){
       $this->navActive= $this->formShow=$no;
    }
    public $nominal;

    public $AthleteWaitingList;
    public $club;
    public $navActive=1;
    public $navigations=[];
    public function mount()
    {
        $this->club=auth()->user()->club;
        $this->nominal=$this->club->registration_fee;
        $this->navigations = [
                  ["no" => 1, "name" => "Active"],
                  ["no" => 2, "name" => "Pending"],
                  ["no" => 3, "name" => "Setting"],
        ];
    }
    public function render()
    {
        Athlete::where('is_deleted',1)->get()->map(function($a){
            athleteClub::where('athlete_id',$a->id)->update(['status'=>0]);
        });
    $athletes=athleteClub::where('club_id',auth()->user()->club->id)->where('status',1)->get();
    $athletes=$athletes->map(function($a){
                return $a->athlete;

            });
            $athletes=$athletes->filter(function($a){
                return $a!=null ;
            });
    $this->AthleteWaitingList=$athletes->where('status',"!=",1);
        return view('livewire.club.club-athlete',['athletes'=>$athletes]);
    }
}
