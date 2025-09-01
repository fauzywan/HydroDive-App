<?php

namespace App\Livewire\User;
use App\Models\User;
use App\Models\Club;
use App\Models\Athlete;
use App\Models\settings;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Flux\Flux;
use Livewire\WithPagination;

class Userindex extends Component
{
    use WithPagination;
    public $modalDelete="destroy";
    public $userId;
    public $keyword="";
    public $first_name;
    public $navigations;
    public $navActive=1;
    public $modalButton="Delete User";
      public function show($id)
      {
          $this->navActive=$id;
    }
      public function mount()
    {
        $this->navigations=[
            ["no"=>1,"name"=>"admin"],
            ["no"=>5,"name"=>"Club"],
            ["no"=>3,"name"=>"Attlete "],
        ];
        $this->navActive=1;
    }
    public $textModal="You're about to delete ";
    public function resetRequest($id){
        $this->userId=$id;
        $this->modalButton="Reset Password";
        $this->modalDelete="resetPassword";
        $this->textModal="Reset password";
        Flux::modal('delete-profile')->show();
    }
    public $email;
    public function updatingKeyword(){
           $this->gotoPage(1);
    }
    public function updatingEmail(){
           $this->gotoPage(1);
    }
    public function edit($id){

        $this->userId=$id;
        $this->email=User::find($id)->email;
        Flux::modal('edit-profile')->show();
    }
    public function update(){
        $rule=['email'=>'email'];
        $this->validate($rule);
        $user=User::find($this->userId);
        if($user->role_id==3){
            dd("athlete");
        }
        if($user->role_id==5){
            $user->club->update(['email'=>$this->email]);
            $user->update(['email'=>$this->email]);
            session()->flash('message',"Data Berhasil Diubah");
            Flux::modal('edit-profile')->close();
            $this->userId="";

        }
        if($user->role_id==6){
            dd("guardian");
        }
    }
    public function delete($id){
        $this->userId=$id;
        Flux::modal('delete-profile')->show();
    }

    public function destroy(){
        $user=User::find($this->userId);
        if($user->role_id==5){
            $club=$user->club;
            if($club->logo){
                Storage::disk('public')->delete('club/' . $club->logo);
            }
            $club->delete();
            $user->delete();
        }
        else if($user->role_id==3){
           $athlete= Athlete::where('email',$user->email)->first();
           if($athlete->photo){
            Storage::disk('public')->delete('athlete/' . $athlete->photo);
           }
           $athlete->delete();
        $user->delete();
        }
        session()->flash('message', 'Data Berhasil Dihapus');
        Flux::modal('delete-profile')->close();
        return $this->redirect('/user',navigate:true);


    }
    public function resetPassword(){
        $user=User::find($this->userId);

        $user->update(['password'=>password_hash(settings::first()->password_default, PASSWORD_DEFAULT)]);
        $this->modalDelete="destroy";
        $this->modalButton="Delete User";
        session()->flash('message', 'Reset Password Berhasil');
        Flux::modal('delete-profile')->close();
        return $this->redirect('/user',navigate:true);
    }

    public function render()
    {
            $users=User::where("email","LIKE","%$this->keyword%")->where('role_id',$this->navActive)->paginate(10);

        return view('livewire.user.userindex',["users"=>$users]);
    }
}
