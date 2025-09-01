<?php

namespace App\Livewire\Coach;

use App\Models\Coach;
use App\Models\coachLicense;
use App\Models\settings;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
class CoachIndex extends Component
{

        use WithPagination;

    public $first_name;
    public $id;
    public function delete($id)
    {
        $coach= Coach::find($id);
        $this->first_name=$coach->name;
        $this->id=$coach->id;
        Flux::modal('delete-profile')->show();
    }
    public function CreateAccount($id)
    {
        $coach=Coach::find($id);
        User::create([
            'name' => $coach->name,
            'email' => $coach->email,
            'password' => password_hash(settings::first()->password_default, PASSWORD_DEFAULT),
            'role_id' => 4,
        ]);
        return $this->redirect('coach',navigate:true);
    }
    public function destroy()
    {
        $lisences= coachLicense::where('coach_id',$this->id)->get();
       if($lisences){
        foreach($lisences as $lisence){
            $lisence->delete();
            Storage::disk('public')->delete('coach/' . $lisence->name);
        }
           Coach::where('id',$this->id)->delete();
           Flux::modal('delete-profile')->close();

    }

        session()->flash('message', 'Data berhasil Dihapus');
        return $this->redirect('/coach',navigate:true);
    }
    public function edit($id){
        return $this->redirect("/coach/$id/edit",navigate:true);
    }
    public function render()
    {
        return view('livewire.coach.coach-index',[
            'coaches' => \App\Models\Coach::where("id","!=",1)->paginate(5),
        ]);
    }
}
