<?php

namespace App\Livewire\Athlete;

use App\Models\Athlete;
use App\Models\AthleteParent;
use App\Models\settings;
use App\Models\User;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class GuardianForm extends Component
{
    public $modalText="Add";
    public $modalSubText="Create New Athlete Data";
    public $first_name;
    public $athleteId;
    public $registration_fee;
    public $athlete;
    public $formType="save";
    public $isEditMode = false;
    public $userLogin;
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
        if($this->formStage<1){
            $this->formStage+=1;
            $this->nextButton="Next";
        }
        if($this->formStage==1){
            $this->prevButton="Back";
            $this->nextButton="Save";
        }

    }
    public function changeFormType($type){
        $this->formType=$type;
    }

    public $name;
    public $email;
    public $phone;
    public $address;
    public $relation;
    public $guardian;
    public $gender="male";
    public $athlete_name;
    public function mount($id=0){
        if(!$id){
            $id=auth()->user()->athlete->id;
        }
        if(Request::segment(3)=="edit"){
        $this->formType="update";
        $guardian=AthleteParent::find($id);
        $athlete=$guardian->athlete;
        $this->guardian=$guardian;
        $this->name=$guardian->name;
        $this->email=$guardian->email;
        $this->phone=$guardian->phone;
        $this->address=$guardian->address;
        $this->relation=$guardian->relation;
        $this->gender=$guardian->gender;

    }else{

        $athlete=Athlete::find($id);
    }
    $this->athlete=$athlete;
    $this->athlete_name=$this->athlete->name();
    }
    public function update()
    {
        if($this->guardian->email!=$this->email){
            $this->guardian->update([
            'email'=>$this->email,
        ]);
        }
        $this->guardian->update([
            'athlete_id'=>$this->athlete->id,
            'name'=>$this->name,
            'phone'=>$this->phone,
            'gender'=>$this->gender,
            'address'=>$this->address,
            'relation'=>$this->relation
        ]);
            session()->flash('message',"Data Berhasil Diedit");
    return $this->redirect("/guardian",navigate:true);

    }
    public function save()
    {
        AthleteParent::create([
        'athlete_id'=>$this->athlete->id,
        'name'=>$this->name,
        'phone'=>$this->phone,
        'email'=>$this->email,
        'gender'=>$this->gender,
        'address'=>$this->address,
        'relation'=>$this->relation]);
          User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => password_hash(settings::first()->password_default, PASSWORD_DEFAULT),
            'role_id' => 2,
        ]);
        $id=$this->athlete->id;
        session()->flash('message',"Data Berhasil Ditambahkan");

    return $this->redirect("/athlete/$id/profile",navigate:true);
    }
    public function render()
    {
        return view('livewire.athlete.guardian.guardian-form');
    }
}
