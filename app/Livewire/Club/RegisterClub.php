<?php

namespace App\Livewire\Club;

use App\Models\Branch;
use App\Models\Club;
use App\Models\ClubBranch;
use App\Models\ClubRegistrationFee;
use App\Models\ClubType;
use App\Models\Coach;
use App\Models\CoachCategory;
use App\Models\settings;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

use Livewire\Component;

class RegisterClub extends Component
{

    public $type_id=1;
    public $clubTypes;
    public $clubId;
    public $registration_fee=0;
    public $documents;
    public $logo;
    #[Rule('required')]
    public $name;
    #[Rule('required')]
    public $nick;
    #[Rule('required|email|unique:clubs,email')]
    public $email;
    public $password_confirmation;
    #[Rule('required|min:6|confirmed')]
    public $password;
    public $leader;
    public $hoc=1;
    public $training_place_status=1;
    public $training_place="";
    public $member=0;
    public $address;
    public $club_registration_fee;
    public $clubBranch=[];
    public $formType="save";
    public $formPage=1;

    public function render()
    {
                $coaches = Coach::where('coach_category_id', 2)
                ->orWhere('id', 1)
                ->get();
        return view('livewire.club.register-club',['coaches'=>$coaches]);

    }

    public function nextnPrev($type=0)
    {
        if($type==0){
         $this->formPage-=1;
        }else{
            $this->formPage+=1;
        }
    }

    public $role_id;
    public function back()
    {

        if($this->role_id==5){
            return $this->redirect('/club/profile', navigate:true);

        }
        return $this->redirect('/club', navigate:true);

    }

    public function update()
    {

        foreach($this->removeBranch as $rmv){
            $branch_id=(Branch::where('name',$rmv)->first()->id);
            $branch=(ClubBranch::where('club_id',$this->clubId)->where('branch_id',$branch_id)->first());
            if($branch->count()>0){
                $branch->delete();
            }
        }

        if(count($this->clubBranch)>0){
            foreach ($this->clubBranch as $bnch) {
               $branch_id= Branch::where('name', $bnch)->first()->id;
                $branch=(ClubBranch::where('club_id',$this->clubId)->where('branch_id',$branch_id)->first());
            if($branch==null){
                ClubBranch::create([
                    'club_id' => $this->clubId,
                    'branch_id' => $branch_id,
                ]);
            }
        }
        $club = Club::find($this->clubId);
  $filename=$club->logo;
        if($this->logo){
            $filename = md5($club->name) . '.' . $this->logo->getClientOriginalExtension();
            $path = $this->logo->storeAs('club', $filename, 'public');
            $club->update(['logo'=>$filename]);
        }
        if($club->email!=$this->email){
            $user=User::where('email',$club->email)->first();
            if($user!=null){
                $user->update(['email'=>$this->email]);
            }
            $club->update([
                'email'=>$this->email,
            ]);
        }

        $rule=[
            'name'=>'required',
            'nick'=>'required',
            'leader'=>'required',
            'hoc'=>'required',
            'member'=>'required',
            'address'=>'required',
        ];$this->validate($rule);
        $club->update([
        'name' => $this->name,
        'nick' => $this->nick,
        'owner' => $this->leader,
        'address' => $this->address,
        'hoc' => $this->hoc,
        'homebase'=> $this->training_place,
        'pool_status' => $this->training_place_status,
        'notarial_deed'=>'',
        'number_of_members' => $this->member,
        'status' => 0,
        'registration_fee' => $this->registration_fee,
       ]);
    }
    session()->flash('message', 'Data berhasil Diubah');
    if($this->role_id==5){
        return $this->redirect('/club/profile', navigate:true);

    }
    return $this->redirect('/club', navigate:true);

    }

    public function save()
    {
        $this->validate();


        $club = Club::create([
            'type_id' => $this->type_id,
            'name' => $this->name,
            'nick' => $this->nick,
            'owner' => "",
            'owner_photo' => "default.png",
            'address' => "",
            'hoc' => 1,
            'homebase'=> 0,
            'pool_status' => 0,
            'notarial_deed'=>'',
            'number_of_members' => 0,
            'email' => $this->email,
            'status' => 6,
            'registration_fee' => 0,
            'registration_link' => "",
            'logo' => "",
        ]);

        $regFee=$this->club_registration_fee;
        if($this->role_id==1)
        {
            ClubRegistrationFee::create([
                'club_id'=>$club->id,
                'fee'=>$regFee,
                'remaining_fee'=>$regFee,
                'status'=>1]);
            }
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => password_hash($this->password, PASSWORD_DEFAULT),
            'role_id' => 5,
        ]);


        if(count($this->clubBranch)>0){
            foreach ($this->clubBranch as $branch) {
               $branch_id= Branch::where('name', $branch)->first()->id;
               ClubBranch::create([
                    'club_id' => $club->id,
                    'branch_id' => $branch_id,
                ]);
        }

    }
session()->flash('message', 'Data berhasil Ditambahkan');
    return redirect()->route('club.index')->with('message', 'Data berhasil disimpan');

}



    public function mount($id=null){
        $this->role_id=0;
        if(auth()->user()){

            $this->role_id=auth()->user()->role_id;
        }
        $this->clubTypes=ClubType::all();
        $this->club_registration_fee=settings::first()->registration_fee;
        $this->brnch = Branch::pluck('name')->toArray();
        if($id){
            $this->clubId=$id;
             $this->formType="update";

            $club = Club::find($id);
            $this->name=$club->name;
            $this->nick=$club->nick;
            $this->leader=$club->owner;
            $this->email=$club->email;
            $this->hoc=$club->hoc;
            $this->training_place_status=$club->pool_status;
            $this->training_place=$club->homebase;
            $this->member=$club->athletes->count();
            $this->registration_fee=$club->registration_fee;

            $this->address=$club->address;
            $this->clubBranch=[];
            foreach($clubBranch=ClubBranch::where('club_id',$id)->get() as $brnc){
                $branch=Branch::find($brnc->branch_id);
                $this->clubBranch[]=$branch->name;

            }
            $this->brnch = array_diff($this->brnch, $this->clubBranch);
            $this->formType="update";

        }
    }


    public $brnch;
    public $branchSelect="Renang";
    public function addToBranch(){

        $this->clubBranch[]=$this->branchSelect;

        $this->brnch = array_filter($this->brnch, function ($branch) {
            return $branch != $this->branchSelect;
        });
        if($this->formType=="update"){
        if (($key = array_search($this->branchSelect, $this->removeBranch ?? [])) !== false) {
            unset($this->removeBranch[$key]);
            $this->removeBranch = array_values($this->removeBranch);
        }
    }
        $this->branchSelect = !empty($this->brnch) ? array_values($this->brnch)[0] : '';
    }

    public $removeBranch=[];
    public function removeFromBranch($index)
    {
        if($this->formType=="update"){
            $this->removeBranch[]=$this->clubBranch[$index];
        }
        $this->brnch[]=$this->clubBranch[$index];
        unset($this->clubBranch[$index]);
        $this->clubBranch = array_values($this->clubBranch);
    }
}
