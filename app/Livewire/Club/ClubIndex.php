<?php

namespace App\Livewire\Club;

use App\Models\Club;
use App\Models\ClubRegistrationFee;
use App\Models\ClubWaitingList;
use Flux\Flux;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class ClubIndex extends Component
{

        public $first_name;
        public $perpage=5;
        public $id;
        public function mount()
        {
            $this->perpage=\App\Models\settings::first()->data_per_page;
        }
        public function Registration($id)
        {
            $club=Club::find($id);
            $regFee=\App\Models\settings::first()->registration_fee;
            ClubRegistrationFee::create([
                'club_id'=>$club->id,
                'fee'=>$regFee,
                'remaining_fee'=>$regFee,
                'status'=>1]);
                return $this->redirect('/club',navigate:true);
        }
        public function delete($id)
        {
            $club= Club::find($id);
            $this->first_name=$club->name;
            $this->id=$club->id;
            Flux::modal('delete-profile')->show();
        }
        public function destroy()
        {
            club::where('id',$this->id)->delete();
            Flux::modal('delete-profile')->close();
            session()->flash('message', 'Data berhasil Dihapus');
            return $this->redirect('/club',navigate:true);
        }
        public function detail($id){
            return $this->redirect("/club/$id/detail",navigate:true);
        }
        public function edit($id){
            return $this->redirect("/club/$id/edit",navigate:true);
        }


    public $waitingCount;
    public function render()
    {

        $this->waitingCount=ClubWaitingList::where('status','!=',0)->where('status','!=',2)->orderBy('created_at','desc')->count();
        if(Request::segment(2)=="member"){
            $clubs= \App\Models\Club::where("id","!=",1)->where('status',1)->paginate($this->perpage);
        }else{
            $clubs= \App\Models\Club::where("id","!=",1)->paginate($this->perpage);
        }
        return view('livewire.club.club-index',[
        'clubs'=>$clubs]);
    }
}
