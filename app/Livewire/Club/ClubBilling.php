<?php

namespace App\Livewire\Club;

use App\Models\Club;
use App\Models\ClubRegistrationFee;
use App\Models\ClubRegistrationTransaction;
use App\Models\EventAdministration;
use App\Models\EventAdministrationTransaction;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithFileUploads;

class ClubBilling extends Component
{
    use WithFileUploads;
    public $club;
    public $pay_time;
    public $transaction_name;
    public $transaction_nominal;
    public $navActive=1;
    public $navigations;
    public function mount()
    {
           $this->navigations=[
            ["no"=>1,"name"=>"Tagihan saya"],
            ["no"=>0,"name"=>"History "],
        ];
        $clubId=auth()->user()->club->id;
        $this->club=Club::find($clubId);
    }
    public $paymentMethods=[];
    public function render()
    {


        $eventAdministration=EventAdministration::where('club_id',$this->club->id)->where('status_fee',$this->navActive)->get();
              $billing = collect();
                if ($eventAdministration) {
                    $billing = $billing->merge(
                        $eventAdministration->map(function ($item) {
                            return (object)[ // casting ke object
                                'id' => $item->id,
                                'name' => $item->athlete->name().' ('.$item->event->name.')' ,
                                'status' => $item->status_fee,
                                'status_2' => $item->status,
                                'nominal' => $item->fee,
                                'club_id' => $item->club_id,
                                'type' => 1
                            ];
                        })
                    );
                }
                if($this->club->register_fee){


                    if ($this->club->register_fee->status==$this->navActive) {
                    $billing->push((object)[
                        'id' => $this->club->register_fee->id,
                        'name' => "Registrasi Keanggotaan",
                        'status' => $this->club->register_fee->status,
                        'nominal' => $this->club->register_fee->fee,
                        'club_id' => $this->club->id,
                        'status_2' => 0,
                        'type' => 2
                    ]);
                }
            }
        return view('livewire.club.club-billing',
        [
            'billings'=>$billing
        ]
    );
    }
    public $morePay=[];
    public $billingPay=0;

public function payMoreBillingModal(){
}
public function selectedMoreBillings($id,$nominal){
  if (($key = array_search($id, $this->morePay)) !== false) {
     $this->billingPay-=$nominal;
    unset($this->morePay[$key]);
    $this->morePay = array_values($this->morePay);
} else {
         $this->billingPay+=$nominal;
        $this->morePay[] = $id;
    }

}
    public $selectedBilling;
public function updatedPaymentMethodSelect()
{
$pm=$this->paymentMethods
            ->where('id', $this->payment_method_select)
            ->first();
    $this->transaction_address = $pm->payment_address;
$this->qrPhoto=$pm->photo;
}
public $qrPhoto="";
public function qrBill($id,$type){
    if($type==1){

        $this->selectedBilling = EventAdministrationTransaction::where('administration_id', $id)->firstOrFail();
        $this->qrPhoto = asset('storage/club/payment/' . $this->selectedBilling->payment_proof);
    }else{
        $this->selectedBilling = ClubRegistrationTransaction::where('club_registration_fee_id', $id)->firstOrFail();
        $this->qrPhoto = asset('storage/club/payment/' . $this->selectedBilling->photo);

    }
  Flux::modal('modal-detail')->show();

}
public $modalTitle="Detail Bukti Pembayaran";
public function detailBilling($id)
{

    if($id==0){
        if($this->qrPhoto==""){
            $this->qrPhoto = asset('storage/default.jpg'); // atau sesuaikan dengan field yang digunakan

        }else{
            $this->modalTitle="Gambar Pendukung Pembayaran";
            $this->qrPhoto = asset('storage/club/payment/method/' . $this->qrPhoto);
        }
    }else{
        $this->modalTitle="Detail Bukti Pembayaran";
        $this->selectedBilling = EventAdministrationTransaction::where('administration_id', $id)->firstOrFail();
        $this->qrPhoto = asset('storage/club/payment/' . $this->selectedBilling->payment_proof);
    }
  Flux::modal('modal-detail')->show();
}
public function closeModal($name){

    Flux::modal($name)->close();
    }
    public function payIt()
    {
        // 1 - Pembayaranan untuk pelaksaaan event
        // 2 - Pembayaran keanggotaan
              $proof="";
              if($this->payType==1){
                  if($this->proof){
                      $proof = md5($this->paySelected->id) . "$this->payment_method_select" ."_event_".'.' . $this->proof->getClientOriginalExtension();
                      $path = $this->proof->storeAs('club/payment/', $proof, 'public');
                    }
            $groupToken =  "";
            EventAdministrationTransaction::create([
                'administration_id'=> $this->paySelected->id,
                'payment_id'=>$this->payment_method_select,
                'amount'=>$this->transaction_nominal,
                'pay_time'=>$this->pay_time,
                'payment_proof'=>$proof,
                'status'=>2,
                 'group_token' => $groupToken,
                'desc'=>'Pembayaran Kompetisi']);

                $this->paySelected->update(['status_fee'=>0,'status'=>2]);
            }else{
            if($this->proof){
                $proof = md5($this->paySelected->id) . "$this->payment_method_select" ."_club_".'.' . $this->proof->getClientOriginalExtension();
                $path = $this->proof->storeAs('club/payment/', $proof, 'public');
            }
                $transaction=ClubRegistrationTransaction::create([
                'club_registration_fee_id'=> $this->paySelected->id,
                'amount'=>$this->transaction_nominal,
                'pay_time'=>$this->pay_time,
                'photo'=>$proof,
                'status'=>2,
                'desc'=>'Pembayaran Keanggotaan']);
        }
           $this->paySelected->update(['status'=>0]);
        session()->flash('message',"Transaksi berhasil");
        $this->closeModal('modal-form');

    }
    public $payType;
    public $payment_method_select;
    public $transaction_address;
    public $paySelected;
    public $proof;

    public function payBilling($id,$type)
    {
        $this->payType=$type;
        if($type==1)
        {
            $paySelected=EventAdministration::find($id);
            $this->paySelected=$paySelected;
            $this->paymentMethods=$paySelected->paymentMethod();
            if($this->paymentMethods->count()>0){
                $this->payment_method_select=$this->paymentMethods[0]->id;
                $this->transaction_address=$this->paymentMethods[0]->payment_address;
                $this->qrPhoto=$this->paymentMethods[0]->photo;

            }
            $this->transaction_name=$paySelected->athlete->name()."(".$paySelected->event->name.")";
            $this->transaction_nominal=$paySelected->fee;

        }else{
            $paySelected=ClubRegistrationFee::find($id);
          $this->paySelected=$paySelected;
          $this->paymentMethods=Club::find(1)->payment_methods;
            if($this->paymentMethods->count()>0){
                $this->payment_method_select=$this->paymentMethods[0]->id;
                $this->transaction_address=$this->paymentMethods[0]->payment_address;
                $this->qrPhoto=$this->paymentMethods[0]->photo;
            }
            $this->transaction_name="Registrasi Keanggotaan";
            $this->transaction_nominal=$paySelected->fee;
        }
        $this->pay_time=date('Y-m-d');
        Flux::modal('modal-form')->show();
    }
    public function show($no)
    {
        $this->navActive=$no;
    }
}
