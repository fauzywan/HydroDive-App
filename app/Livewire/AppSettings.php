<?php

namespace App\Livewire;

use App\Models\Club;
use App\Models\PaymentMethod;
use App\Models\PaymentMethodClub;
use App\Models\settings;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class AppSettings extends Component
{
    use WithFileUploads;
    public function render()
    {
        return view('livewire.app-settings');
    }
public $paymentMethods;

public $formShow = 1;
public $nominal;
public $club;
public $defaultPassword;

public function show($val)
{
    $this->formShow = $val;
}
public function mount()
{
        $this->paymentMethods=PaymentMethod::all();
if($this->buttonType="newMethod")
{
    $this->payment_method_select=0;
}
    $this->club=\App\Models\Club::find(1);
    $settings=settings::first();
    $this->nominal = $settings->registration_fee;
    $this->defaultPassword = $settings->password_default;
}
public function setRegistrationFee()
{
    $this->validate([
        'nominal' => 'required|numeric|min:0',
    ]);

    $settings=settings::first();
    $settings->update([
        'registration_fee' => $this->nominal,
    ]);

    session()->flash('message', 'Registration fee berhasil disimpan.');
}

public function setDefaultPassword()
{

    $this->validate([
        'defaultPassword' => 'required|string',
    ]);

    $settings=settings::first();
    $settings->update([
        'password_default' => $this->defaultPassword,
    ]);

    session()->flash('message', 'Password default berhasil disimpan.');
}
 public $first_name;
    public $payment_method_input;
    public $payment_method_address;
    public $payment_method_select=1;
    public $photoQr;
public function updatedPaymentMethodSelect()
{
    $this->payment_method_input="";
}
public $modalType=1;
    public function addPaymentMethod(){
        $this->modalType=1;
        if(!$this->paymentMethods->count()){
            $this->payment_method_select=0;
        }
        Flux::modal('modal-document')->show();
        $this->buttonType="newMethod";

    }
    public $pm;
    public $buttonType="newMethod";
    public function editMethod($id){
        $this->modalType=1;
        $this->buttonType="updateMethod";
         $this->pm=PaymentMethodClub::find($id);
         $this->payment_method_select=$this->pm->payment_method_id;
         $this->payment_method_address=$this->pm->payment_address;

        Flux::modal('modal-document')->show();

    }
     public function updateMethod(){

        if($this->payment_method_input!=""){
            $payment_method_select= PaymentMethod::create(['name'=>$this->payment_method_input]);
            $this->payment_method_select=$payment_method_select->id;
        }
        $filename="";
        if($this->pm->photo!=""){
            Storage::disk('public')->delete('club/payment/method/' . $this->pm->photo);
        }
        if($this->photoQr){
            $filename = md5($this->club->name) . "$this->payment_method_select" .'.' . $this->photoQr->getClientOriginalExtension();
            $path = $this->photoQr->storeAs('club/payment/method', $filename, 'public');
        }
        $this->pm->update([
            'payment_method_id'=>$this->payment_method_select,
        'club_id'=>$this->club->id,
        'payment_address'=>$this->payment_method_address,
        'photo'=>$filename]);
          session()->flash('message', 'insert successfully.');
          Flux::modal('modal-document')->close();
           $this->payment_method_input="";
           $this->payment_method_address="";
           $this->payment_method_select=1;
           $this->photoQr;
            $this->paymentMethods=PaymentMethod::all();
    }
    public function deleteMethod($id){
        $this->modalType=0;
           $this->pm=PaymentMethodClub::find($id);
           $this->first_name=$this->pm->id;
        Flux::modal('modal-document')->show();

    }
    public function destroyMethod(){

        if($this->pm->photo!=""){
            Storage::disk('public')->delete('club/payment/method/' . $this->pm->photo);

        }
        $this->pm->delete();
          session()->flash('message', 'delete successfully.');
            $this->paymentMethods=PaymentMethod::all();
          Flux::modal('modal-document')->close();
    }
 public function newMethod()
    {

        if($this->payment_method_input!=""){
            $payment_method_select= PaymentMethod::create(['name'=>$this->payment_method_input]);
            $this->payment_method_select=$payment_method_select->id;
        }
        $filename="";
        if($this->photoQr){
            $filename = md5($this->club->name) . "$this->payment_method_select" .'.' . $this->photoQr->getClientOriginalExtension();
            $path = $this->photoQr->storeAs('club/payment/method', $filename, 'public');
        }
        PaymentMethodClub::create([
            'payment_method_id'=>$this->payment_method_select,
        'club_id'=>$this->club->id,
        'payment_address'=>$this->payment_method_address,
        'photo'=>$filename]);
          session()->flash('message', 'insert successfully.');
          Flux::modal('modal-document')->close();
           $this->payment_method_input="";
           $this->payment_method_address="";
           $this->payment_method_select=1;
           $this->photoQr="";
            $this->paymentMethods=PaymentMethod::all();

    }
}
