<?php

namespace App\Livewire\Coach;

use App\Models\Coach;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CoachProfile extends Component
{
    public function render()
    {
        if($this->role_id!=3){
            $email=$this->coach->email;

        }else{

            $email=auth()->user()->email;
        }


        return view('livewire.coach.coach-profile' ,['coach' => Coach::where("email",$email)->first()
        ]);
    }
    use WithFileUploads;
    public $formStage=1;
    public $formShow=1;
    public $coach;
    public $profile =null;
    public function show($no){
        $this->formShow=$no;
    }

    public function mount($id=null)
    {
        if($id){
            $this->role_id=auth()->user()->role_id;
            $this->coach=Coach::find($id);

        }else{

            $this->coach=Coach::where("email",auth()->user()->email)->first();
        }
    }
    public $role_id=3;

    public function updateUserProfile()
    {
        if($this->profile){

            Storage::disk('public')->delete('coach/' . $this->coach->profile    );
            $filename = md5($this->coach->name) . '.' . $this->profile->getClientOriginalExtension();
            $path = $this->profile  ->storeAs('coach', $filename, 'public');
            $this->coach->update([
                'profile' => $filename,
            ]);
            session()->flash('message', 'Profile profile     updated successfully.');
            if(auth()->user()->role_id==1){
                $coachID=$this->coach->id;
                return  $this->redirect("/coach/$coachID/profile",navigate:false);

            }
            if(auth()->user()->role_id==4){

                return   $this->redirect("/coach/profile",navigate:false);
            }
            if(auth()->user()->role_id==5){
                $idd=$this->coach->id;
             return   $this->redirect("/coach/$idd/profile",navigate:false);
            }
            $this->redirect('/profile',navigate:false);
        }
    }
    public function updatedprofile  ()
    {
        Flux::modal('edit-profile')->show();

    }
    public function edit($id){
        if(auth()->user()->role_id==1){
            $coach=$this->coach->id;
        }
        else if(auth()->user()->role_id==5){
            $coach=Coach::find($id)->id;

        }
        else{

            $coach=auth()->user()->coach->id;
        }
        return $this->redirect("/coach/$coach/edit",navigate:true);
    }
}


