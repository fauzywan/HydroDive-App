<?php

namespace App\Livewire\Club;

use Livewire\Component;

use App\Models\ClubWaitingList as waitingList;
use App\Models\Club;
use App\Models\ClubRegistrationFee;
use App\Models\ClubRegistrationTransaction;
use App\Models\Coach;
use App\Models\settings;
use Flux\Flux;
use Livewire\WithPagination;

class ClubRegisterFeeList extends Component
{
    use WithPagination;

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
    public $clubEmail;
    public $clubLogo;
    public $waitingId;
    public function rejectedClub(){
        $this->selectClub=$this->approval;
    }
    public function mount()
    {


        $this->segment=request()->segment(2);
    }

    public function setAllRegistrationFee()
    {
        settings::first()->update(['registration_fee'=>$this->nominal]);
        session()->flash('message',"Nominal Terlalu besar");
        return $this->redirect('/club-administration/setting',navigate:true);
    }
    public $wlCount;
    public $wlConfirmCount;
    public function render()
    {
        $waitingList=Club::where('status',6)->where('id','!=',1)->paginate(5);
        $waitingList=$waitingList->filter(function($wl)
        {
            if(!$wl->register_fee){
                return $wl;
            }
         });
        $this->wlCount=$waitingList->count();
        $this->wlConfirmCount=ClubRegistrationTransaction::where('status',2)->count();

        if ($this->segment=='') {
            $waitingList=ClubRegistrationFee::where('status','!=',0)->where('club_id','!=',1)->orderBy('created_at','desc')->paginate(5);
        }
        elseif ($this->segment=='setting') {
            $this->nominal=settings::first()->registration_fee;
            $waitingList=[];
        }
        elseif ($this->segment=='confirm') {
            $waitingList=ClubRegistrationTransaction::where('status',2)->paginate(5);

        }
        elseif ($this->segment=='history') {
            $waitingList=ClubRegistrationTransaction::where('status',"!=",2)->orderBy('created_at','desc')->paginate(5);
        }
        elseif ($this->segment=='pending') {
            $this->wlCount=0;
        }
        return view('livewire.club.club-register-fee-list',['waitingList'=>$waitingList]);
        }
    public $clubRegistration;

    public $payClubName;
    public $proof;
    public $nominal;
    public $qrPhoto;
    public $payNominal;
    public $payDate;
    public $tanggal_bayar;
    public $tanggal;
    public $nama;
    public function history($id)
    {
            $history=ClubRegistrationTransaction::find($id);
        $this->qrPhoto=asset("storage/club/payment/".$history->photo);
        $this->nama=$history->clubRegistrationFee->club->name;
        $this->tanggal_bayar=$history->pay_time;
        Flux::modal('modal-detail')->show();
    }
    public function payModal($id)
    {
        $this->clubRegistration=ClubRegistrationFee::find($id);
        $this->payClubName=$this->clubRegistration->club->name;
        $this->payNominal=$this->clubRegistration->fee;
        $this->payDate=date('Y-m-d');
       Flux::modal('pay-club')->show();
    }
    public function transactionClub()
    {
        $this->validate([
            'proof'=>'required',
            'payNominal'=>'required|numeric|min:1',
            'payDate'=>'required|date',
        ]);

        if($this->payNominal>$this->clubRegistration->remaining_fee){
            session()->flash('message',"Nominal Terlalu besar");
            return $this->redirect('/club-administration',navigate:true);
        }
         if($this->proof){
                $proof = md5($this->clubRegistration->id) . "admin" ."_club_".'.' . $this->proof->getClientOriginalExtension();
                $path = $this->proof->storeAs('club/payment/', $proof, 'public');
            }
            ClubRegistrationTransaction::create([
                'club_registration_fee_id'=> $this->clubRegistration->id,
                'amount'=>$this->payNominal,
                'pay_time'=>$this->payDate,
                'photo'=>$proof,
                'status'=>1,
                'desc'=>'Pembayaran Keanggotaan']);
                $this->clubRegistration->update(['status'=>0]);


        // $remaining=$this->clubRegistration->remaining_fee-$this->payNominal;
        // $this->clubRegistration->update(['remaining_fee'=>$remaining]);
        // if($remaining<=0){
        //     $this->clubRegistration->update(['status'=>0]);
        // }
        session()->flash('message',"Transasi Berhasil");
        return $this->redirect('/club-administration',navigate:true);
    }
    public $segment;
    public $clubSet;
    public function setFeeClub($id){
        $this->payClubName=Club::find($id)->name;
        $this->payNominal=settings::first()->registration_fee;
        $this->clubSet=$id;
        Flux::modal('set-pay-club')->show();
    }
    public function setRegistrationFeeClub(){
        ClubRegistrationFee::create(['club_id'=>$this->clubSet,'fee'=>$this->payNominal,'remaining_fee'=>$this->payNominal,'status'=>1]);
        Club::find($this->clubSet)->update(['status'=>2]);
        session()->flash('message',"Proses Berhasil");
        return $this->redirect('/club-administration/pending',navigate:true);
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
        $this->clubMember=$club->number_of_members;
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
    public $typeButton="primary";
    public $idConfirm;

    public $confirmType;
    public function confirmPay($id,$status)
    {
         $this->idConfirm=$id;
         $this->confirmType=$status;
        if($status==1){
            $this->typeButton="primary";
        }else{

            $this->typeButton="danger";
        }
        Flux::modal('confirm-modal')->show();
    }
    public function confirmPayment()
    {
        $transaction=ClubRegistrationTransaction::find($this->idConfirm);
        if($this->confirmType!=1){
            // JIka ditolah
            // Update status transaksi menjadi 0 - ditolak
            // Update status club registration fee menjadi 1 -kembali harus membayar
            $transaction->update(['status'=>0]);
            $transaction->clubRegistrationFee->update(['status'=>1]);
            session()->flash('message',"Transaksi ditolak");
            Flux::modal('confirm-modal')->close();
        }else{
            $transaction->update(['status'=>1]);
            $transaction->clubRegistrationFee->update(['status'=>0]);
            $transaction->clubRegistrationFee->club->update(['status'=>0]);
            session()->flash('message',"Transaksi Terkonfirmasi");
            Flux::modal('confirm-modal')->close();
        }

    }
}

