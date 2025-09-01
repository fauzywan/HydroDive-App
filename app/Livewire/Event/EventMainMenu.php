<?php

namespace App\Livewire\Event;

use App\Models\Athlete;
use App\Models\athleteClub;
use App\Models\Event as Events;
use App\Models\EventAdministration;
use App\Models\EventAdministrationTransaction;
use App\Models\EventBranch;
use App\Models\EventClub;
use App\Models\EventHeat;
use Flux\Flux;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Livewire\WithFileUploads;

class EventMainMenu extends Component
{
    use WithFileUploads;
    public $searchAthlete;
    public $clubId;
    public $athlete_select;
    public $branch_select;
    public $event;
    public $eventClub;
    public $paymentMethods;
    public function mount($id)
    {

        $this->pay_time=date('Y-m-d');
        $this->navigations=[
            ["no"=>1,"name"=>"Dashboard"],
            ["no"=>5,"name"=>"Nomor Acara"],
            ["no"=>2,"name"=>"Billing "],
            ["no"=>3,"name"=>"Athlete"],
            ["no"=>4,"name"=>"Sesi"],
        ];
        $this->navActive=1;
        $this->event=Events::find($id);
         $start = $this->event->competition_start;
        $end = $this->event->competition_end;
      $this->eventClub = EventClub::where('club_id', auth()->user()->club->id)
    ->where('created_at', ">=", $start)
    ->where('created_at', "<=", $end)
    ->first();

    $this->paymentMethods=$this->event->club->payment_methods;
        if($this->paymentMethods->count()>0)
        {
            $firstPm=$this->paymentMethods->first();
            $this->payment_method_select=$firstPm->id;
                $this->transaction_address = $firstPm->payment_address;
                $this->qrPhoto=$firstPm->photo;
        }
        if(auth()->user()->role_id==1){

            $this->clubId=1;
        }else{

            $this->clubId=auth()->user()->club->id;
        }
        $athlete=athleteClub::where('club_id',$this->clubId)->where('status',1)->get();
        if($athlete->count()>0){
            $athlete=$athlete->map(function($a){
                return $a->athlete;
            });
        $this->athlete_select=$athlete->first()->id;
    }
        if($this->event->branches->count()>0){
            $this->branch_select=$this->event->branches->first()->id;
            $this->sessionForm = [
                'name' => '',
    'branch_id' => $this->branch_select,
    'capacity' => 0,
    'elimination' => 0,
    'status' => 1,
];
}

    }
    public function savePartisipan(){
        $branch=EventBranch::find($this->branch_select);
        if(EventAdministration::where('athlete_id',$this->athlete_select)->where('event_branch_id',$this->branch_select)->count()){

            session()->flash('message','Gagal Menambahkan atlet,Atlet Sudah terdaftar');
            Flux::modal('modal-form')->close();
            return;
        }
        EventAdministration::create([
                'event_id'=>$branch->event_id,
                'event_branch_id'=>$branch->id,
                'club_id' =>$this->clubId,
                'athlete_id'=>$this->athlete_select,
                'fee'=>$branch->registration_fee,
                'status_fee'=>1,
                'status'=>0
             ]);
             session()->flash('message','Berhasil Menambahkan atlet,Selesaikan administrasi Anda');
             Flux::modal('modal-form')->close();
    }
   public $nominalSelected =0;
   public array $selectedAdministrations = [];
   public $selectAll = false;

public function toggleSelectAll()
{
    if ($this->selectAll) {
       $administrations = $this->event->administration->where('club_id',$this->clubId)->where('status_fee',1);
        $this->selectedAdministrations = $administrations->pluck('id')->toArray();
        $this->nominalSelected = $administrations->where('status_fee',1)->where('club_id',$this->clubId)->sum('fee');
    } else {
        $this->selectedAdministrations = [];
    }
}
public function updatedPaymentMethodSelect()
{
$pm=$this->paymentMethods
            ->where('id', $this->payment_method_select)
            ->first();
    $this->transaction_address = $pm->payment_address;
$this->qrPhoto=$pm->photo;
}
   public function updateSelected($nominal,$id)
   {
        if(in_array($id,$this->selectedAdministrations)){
            $this->nominalSelected+=$nominal;
            if($this->event->administration->count()==count($this->selectedAdministrations)){

                $this->selectAll=true;
            }
        }else{
            $this->selectAll=false;
            $this->nominalSelected-=$nominal;
        }
   }

     public $payment_method_select;
    public $transaction_address;
    public $transaction_name;
    public $transaction_nominal;
    public $paySelected;
    public $proof;
    public $pay_time;
    public $qrPhoto;
    public $modalTitle;
public function generateGroupToken()
{
    $datePart = Carbon::now()->format('dmy'); // hasilnya: 010625
    $randomPart = strtoupper(Str::random(6));
   return "GRP-{$datePart}-{$randomPart}";
}
 public function payIt()
    {
        // 1 - Pembayaranan untuk pelaksaaan event
        // 2 - Pembayaran keanggotaan

              $proof="";
                 if($this->transactionType==2)
         {


            $groupToken = $this->generateGroupToken();
              foreach ($this->selectedAdministrations as $selected) {
                    $this->paySelected=EventAdministration::find($selected);
              if($this->proof){
                      $proof = md5($this->paySelected->id) . "$this->payment_method_select" ."_event_".'.' . $this->proof->getClientOriginalExtension();
                      $path = $this->proof->storeAs('club/payment/', $proof, 'public');
                    }
            EventAdministrationTransaction::create([
                'administration_id'=> $this->paySelected->id,
                'payment_id'=>$this->payment_method_select,
                'amount'=>$this->paySelected->fee,
                'pay_time'=>$this->pay_time,
                'payment_proof'=>$proof,
                'status'=>2,
                 'group_token' => $groupToken,
                'desc'=>'Pembayaran Kompetisi']);

                $this->paySelected->update(['status_fee'=>0,'status'=>2]);
              }
$this->toggleSelectAll();
 $this->selectAll=false;

         }else{
                 if($this->proof){
                      $proof = md5($this->paySelected->id) . "$this->payment_method_select" ."_event_".'.' . $this->proof->getClientOriginalExtension();
                      $path = $this->proof->storeAs('club/payment/', $proof, 'public');
                    }
                      EventAdministrationTransaction::create([
                'administration_id'=> $this->paySelected->id,
                'payment_id'=>$this->payment_method_select,
                'amount'=>$this->paySelected->fee,
                'pay_time'=>$this->pay_time,
                'payment_proof'=>$proof,
                'status'=>2,
                 'group_token' => "",
                'desc'=>'Pembayaran Kompetisi']);

                $this->paySelected->update(['status_fee'=>0,'status'=>2]);
         }

            Flux::modal('modal-form')->close();
  session()->flash('message', 'Proses Transaksi Berhasil,Menunggu Konfirmasi Dari Penyelenggara');
}
   public function detailBilling($id=0)
   {
     if($id==0){
        if($this->qrPhoto==""){
            $this->qrPhoto = asset('storage/default.jpg'); // atau sesuaikan dengan field yang digunakan

        }else{
            $this->modalTitle="Gambar Pendukung Pembayaran";
            $this->qrPhoto = asset('storage/club/payment/method/' . $this->qrPhoto);
        }
    }
  Flux::modal('modal-detail')->show();
   }
   public $transactionType=1;
   public function payTransaction($id)
   {
        $this->transactionType=1;
    $this->paySelected=EventAdministration::find($id);
     $this->transaction_nominal=$this->paySelected->fee;
        $this->transaction_name="Transaksi ".$this->event->name;
        if($this->transaction_nominal!=0){

            Flux::modal('modal-form')->show();
        }

   }
   public function payMoreTransaction()
   {
    $this->transactionType=2;
    $this->transaction_nominal=$this->nominalSelected;
        $this->transaction_name="Transaksi ".$this->event->name;
        if($this->transaction_nominal!=0){

            Flux::modal('modal-form')->show();
        }
   }
    public function addSession()
    {
        Flux::modal('modal-session')->show();
    }
    public function addAthlete()
    {
        Flux::modal('modal-form')->show();
    }
    public $navActive;
    public function render()
    {

        return view('livewire.event.event-main-menu');
    }
    public function closeModal($name)
    {
        Flux::modal($name)->close();
    }

    public $navigations;
    public function registerEventBranch($id)
    {
        $clubId=auth()->user()->club->id;
        $branch=EventBranch::find($id);
        EventAdministration::create([
            'event_id'=>$branch->event_id,
            'event_branch_id'=>$branch->id,
            'club_id'=>$clubId,
            'fee'=>$branch->registration_fee,
            'status'=>1,
        ]);
        session()->flash('message', 'Berhasil Mendaftar,Selesaikan Proses Administrasi');

    }
    public function registerEvent($id)
{
    $this->eventClub->update(['status'=>2]);
    $this->dispatch('eventRegistered', eventId: $this->eventClub->event_id);

    session()->flash('message', 'Permintaan Dikirim, Silahkan Tunggu Konfirmasi Dari Penyelenggara');
}
    //  public function registerEvent($id)
    // {
    //     $this->eventClub->update(['status'=>2]);
    // //     if(EventClub::where('event_id',$id)->where('club_id',$this->club->id)->exists()){
    // //         session()->flash('message', 'You have already registered for this event.');
    // //         return;
    // //     }

    // //    $event= EventClub::create([
    // //         'event_id' => $id,
    // //         'club_id' => $this->club->id,
    // //         'status' => 2,
    // //     ]);
    //     session()->flash('message', 'Permintaan Dikirim, Silahkan Tunggu Konfirmasi Dari Penyelenggara');
    // }
    public $typeView="list";
    public function setViewMode($type){
         $this->typeView=$type;
    }
    public $formShow=1;
    public function show($no){
        $this->formShow=$no;
        $this->navActive=$no;

    }
    public function bayar($id)
    {
        // EventAdministration::where('event_branch_id',$id)->update(['status'=>0]);

        // session()->flash('message', 'Berhasil Mendaftar,Selesaikan Proses Administrasi');
    }
    public $sessionForm = [
    'name' => '',
    'branch_id' => null,
    'capacity' => 0,
    'elimination' => 0,
    'status' => 1,
];

public function saveSession()
{
    $this->validate([
        'sessionForm.name' => 'required|string',
        'sessionForm.branch_id' => 'required|exists:event_branches,id',
        'sessionForm.capacity' => 'required|integer|min:1',
        'sessionForm.elimination' => 'required|integer|min:0',
        'sessionForm.status' => 'required|boolean',
    ]);

    EventHeat::create([
        'event_id' => $this->event->id,
        ...$this->sessionForm,
    ]);

    $this->reset('sessionForm');
    $this->dispatch('close-modal', name: 'modal-form-session');
    $this->dispatch('notify', type: 'success', message: 'Session berhasil ditambahkan.');
}
}
