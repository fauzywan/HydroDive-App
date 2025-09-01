<?php

namespace App\Livewire\Club;

use App\Models\ClubFacility as FacilityofClub;
use App\Models\Facility;
use Flux\Flux;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class ClubFacility extends Component
{
use WithFileUploads;
    public $first_name;
    public $facilitySearch;
    public $facilities;
    public $clubID;
    #[Rule('required')]
    public $name;
    #[Rule('required')]
    public $desc;
    #[Rule('required')]
    public $status=1;
    #[Rule('required')]
    public $photo;
    public $facility;
    public function destroy(){
        $this->facility->delete();
        session()->flash('message', 'Data berhasil ditambahkan');
        return $this->redirect('/club/facility', navigate: true);

    }
    public function delete($id){
        $this->facility=FacilityofClub::find($id);
        $this->first_name=$this->facility->name;
        $this->clubID=$id;
        Flux::modal('delete-profile')->show();

    }
        public $selectedImage = null;
public $showImageModal = false;

public function showImage($image)
{
    $this->selectedImage = $image;
    $this->showImageModal = true;
}

    public function save(){
        $club=auth()->user()->club;
        if($this->photo){
            $clubFotoName=$this->name."_".date('ymd_his')."_".$club->id;
            $namaProfile=$clubFotoName . '.' . $this->photo->getClientOriginalExtension();
            $this->photo->storeAs('club/facility', $namaProfile, 'public');
            $this->photo=$namaProfile;
        }else{
            $this->photo="";
        }

        $coach = FacilityofClub::create([
            'name' => $this->name,
            'club_id' => $club->id,
            'desc' => $this->desc,
            'status' => $this->status,
            'photo' => $this->photo,
        ]);

        session()->flash('message', 'Data berhasil ditambahkan');

        if(auth()->user()->role_id==5){

            return $this->redirect('/club/facility', navigate: true);
        }
        return $this->redirect('/coach', navigate: true);
    }
    public $id;
    public function edit(){
        $facility= FacilityofClub::find($this->id);
        $this->name=$facility->name;
        $this->desc=$facility->desc;
        $this->status=$facility->status;
        $this->formType="update";

        Flux::modal('detail-facility')->close();
        Flux::modal('modal-form')->show();
    }
    public $statusFacility;
    public function profile($id){
        $this->id=$id;

        $facility= FacilityofClub::find($id);
        $this->name=$facility->name;
        $this->desc=$facility->desc;
        $this->status=$facility->status;
        $status="Dimiliki";
        if($facility->status==1){
            $status="Dimiliki";
        }
        else if($facility->status==2){
            $status="Sewa";
        }
        else if($facility->status==3){
            $status="Kolam Umum";
        }

        $this->statusFacility=$status;


        Flux::modal('detail-facility')->show();
    }
    public function mount(){
        if(auth()->user()->role_id==5){
            $this->clubID=auth()->user()->club->id;
        }
        $this->facilities=FacilityofClub::where('club_id',$this->clubID)->get();

    }
    public $formType="save";
    public function update(){
        $facility= FacilityofClub::find($this->id);
        $facility->name=$this->name;
        $facility->desc=$this->desc;
        $facility->status=$this->status;
        $facility->save();
        session()->flash('message', 'Data berhasil ditambahkan');
        return $this->redirect('/club/facility', navigate: true);
    }
    public function addFacility(){
        $this->name="";
        $this->desc="";
        $this->status=1;
        $this->photo="";
        $this->formType="save";
        Flux::modal('modal-form')->show();
    }
    public function render()
    {

        $facilityCategory=Facility::all();
        if($facilityCategory->count() > 0){
            $this->name=$facilityCategory[0]->name;
        }
        return view('livewire.club.club-facility',[
            'facilityCategory'=>$facilityCategory,
        ]);
    }
}
