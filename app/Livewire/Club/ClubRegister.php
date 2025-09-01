<?php

namespace App\Livewire\Club;
use App\Models\Branch;
use App\Models\Club;
use App\Models\ClubBranch;
use App\Models\ClubWaitingList;
use App\Models\Coach;
use App\Models\CoachCategory;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.register')]
class ClubRegister extends Component
{
    public function render()
    {
        $coaches = Coach::where('coach_category_id', 2)
        ->orWhere('id', 1)
        ->get();
        return view('livewire.club.club-register',['coaches'=>$coaches]);
    }
    use WithFileUploads;
    public $clubId;
    public $documents;
    #[Rule('nullable|image|max:1024')]
    public $logo;
    #[Rule('required')]
    public $name;
    #[Rule('required|unique:clubs,nick')]
    public $nick;
    #[Rule('required')]
    public $leader;
    #[Rule('required')]
    public $hoc=1;
    #[Rule('required')]
    public $training_place_status=1;
    #[Rule('required')]
    public $training_place;
    #[Rule('required')]
    public $member;
    #[Rule('required')]
    public $address;
    #[Rule('required|email|unique:clubs,email')]
    public $email;
    public $clubBranch=[];
    public $formType="save";



    public function save()
    {
        $logo="";
        $this->validate();
        if($this->logo){
            $filename=$this->nick . '.' . $this->logo->getClientOriginalExtension();
            $path = $this->logo->storeAs('club', $filename, 'public');
            $logo = $filename;
        }

        $club = Club::create([
            'name' => $this->name,
            'nick' => $this->nick,
            'owner' => $this->leader,
            'owner_photo' => "default.png",
            'address' => $this->address,
            'hoc' => $this->hoc,
            'homebase'=> $this->training_place,
            'pool_status' => $this->training_place_status,
            'notarial_deed'=>'',
            'number_of_members' => $this->member,
            'email' => $this->email,
            'status' => 0,
            'registration_fee' => 0,
            'logo' => $logo,
        ]);
        ClubWaitingList::create([
            'club_id'=>$club->id,
            'status'=>1,
            'message'=>null,
            'Approver'=>'',
        ]);
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => password_hash('123', PASSWORD_DEFAULT),
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

    public function updatingName(){
        if (!is_string($this->name) || empty($this->name)) return '';
        $kata = explode(' ', $this->name);
        $abv = '';
        foreach ($kata as $k) {
            if (!empty($k)) {
                $abv .= strtoupper($k[0]);
            }
        }
        $this->nick= $abv;
    }
    public function mount($id=null){
        $this->brnch = Branch::pluck('name')->toArray();

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
