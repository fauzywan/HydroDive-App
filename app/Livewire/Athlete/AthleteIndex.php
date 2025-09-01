<?php

namespace App\Livewire\Athlete;

use App\Models\Athlete;
use App\Models\athleteClub;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class AthleteIndex extends Component
{
    use WithPagination;
    public $keyword;
    public $searchBy="name";
    public $sortBy=1;
    // #[Layout('components.layouts.header')]

    public function sortING(){
        $this->sortBy= $this->sortBy;
    }
    public $MaleTotal=0;
    public function render()
    {
            $athletes=Athlete::where('is_deleted',false)->where("first_name","LIKE","%$this->keyword%")->paginate(5);
            if($athletes->count() > 0){
                $this->MaleTotal=Athlete::where("first_name","LIKE","%$this->keyword%")->where('gender','male')->count();
            }
        return view('livewire.athlete.athlete-index',['athletes'=>$athletes]);
    }
    public function updatingKeyword(){
        $this->gotoPage(1);
    }

    public $athlete;
    public $athleteId;
    public $first_name;
    public function delete($id){
            $this->athlete=Athlete::findorfail($id);
            $this->athleteId=$id;
            $this->first_name=$this->athlete->first_name;
            Flux::modal('delete-profile')->show();
        }
        public function destroy(){
            if($this->athlete->photo!=""){

                Storage::disk('public')->delete('athlete/' . $this->athlete->photo);
            }
            $athlete=Athlete::find($this->athleteId);
            athleteClub::where('athlete_id',$this->athleteId)->where('status',1)->update(['status'=>0]);
            $count=date("Ymdhis");
            $athlete->update(['is_deleted'=>true,'email'=>$count]);
            User::where('email',$athlete->email)->delete();

                 // Athlete::destroy($this->athleteId);
            session()->flash('message', 'Data berhasil Dihapus');
            return $this->redirect('/athlete',navigate:true);
        }

    public function edit($id)
    {

    }

}
