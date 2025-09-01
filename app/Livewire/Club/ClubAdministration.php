<?php

namespace App\Livewire\Club;

use App\Models\Athlete;
use App\Models\RegistrationFee;
use App\Models\TransactionAthlete;
use Flux\Flux;
use Livewire\Component;

class ClubAdministration extends Component
{
    public $club;

    public function mount(){
       $this->club= auth()->user()->club;
       $this->athlete_money_date=date('Y-m-d');
    }
    public $searchAthlete;
    public $athleteSearch;

    public $registration_fee;
    public $athlete;
    public $athleteId;
    public $keyword;
    public $searchBy="name";

    public function addAthleteWithFee(){
        $this->athlete->update(['club_id'=>auth()->user()->club->id,'status'=>1]);
        $this->athlete->club->update(['number_of_members'=>Athlete::where('club_id',$this->athlete->club_id)->count()]);

        $paid=0;
        if($this->registration_fee==0){
            $paid=1;
        }
        RegistrationFee::create(['athlete_id'=>$this->athlete->id,'club_id'=>$this->athlete->club_id,'amount'=>$this->registration_fee,'remaining_amount'=>$this->registration_fee,'paid'=>$paid]);
        return $this->redirect('/club/athlete',navigate:true);
    }
    public function recruitAthlete($id=null)
    {
        if($id){
            $this->registration_fee=auth()->user()->club->registration_fee;
            $this->athlete=Athlete::find($id);
            Flux::modal('modal-fee')->show();

        }else{

            Flux::modal('search-athlete')->show();
        }
    }
    public function searchingAthlete()
    {
        $this->athleteSearch=Athlete::where('first_name',"LIKE","%$this->searchAthlete%")->where('last_name',"LIKE","%$this->searchAthlete%")->where('club_id','!=',auth()->user()->club->id)->get();

    }
    public function delete($id){
        $this->athlete=Athlete::findorfail($id);
        $this->athleteId=$id;
        $this->first_name=$this->athlete->name;
        Flux::modal('delete-modal')->show();
    }
    public function destroy(){


        $athlete=Athlete::find($this->athleteId);
        $club_id=$athlete->club_id;
        $athlete->club->update(['number_of_members'=>Athlete::where('club_id',$club_id)->count()-1]);
        $athlete->update(['club_id'=>1]);
            session()->flash('message', 'Data berhasil Dihapus');
            return $this->redirect('/club/athlete',navigate:true);

        }

        public $athlete_name;
        public $athlete_money;
        public $athlete_money_date;
        public $athlete_money_file;
        public $fee;
        public function payAthlete(){
            $remain=intval($this->fee->remaining_amount)-intval($this->athlete_money);
            if($remain<0){
                session()->flash('error', 'Jumlah Pembayaran Melebihi Jumlah yang Harus Dibayar');
                   Flux::modal('pay-athlete')->close();
                   $this->athlete_money=0;
            }else{

            TransactionAthlete::create(['registration_fee_id'=>$this->fee->id,'amount'=>$this->athlete_money,'pay_time'=>$this->athlete_money_date,'desc'=>'']);
            $remain=intval($this->fee->remaining_amount)-intval($this->athlete_money);
            $pay=0;
            if($remain<=0){
                $pay=1;
            }
            $this->fee->update(['remaining_amount'=>$remain,'paid'=>$pay]);
            if($remain==0){
             $this->fee->athlete->update(['status'=>1]);
            }
         
            session()->flash('message', 'Transaksi Berhasil');
            return $this->redirect('/club/administration',navigate:true);
            }

        }
        public $showPage=1;
        public function show($no)
        {
            $this->showPage=$no;
        }
        public function pay($id)
        {
            $this->fee=(RegistrationFee::find($id));
            $this->athlete_name=$this->fee->athlete->name();
            Flux::modal('pay-athlete')->show();

        }
        public $first_name;
       public $nominal;
            public function render()
            {
                $this->nominal=$this->club->registration_fee;

                $athletes=RegistrationFee::where('club_id',$this->club->id)->where('paid',0)->get();

                return view('livewire.club.club-administration',['athletes'=>$athletes]);
            }

}
