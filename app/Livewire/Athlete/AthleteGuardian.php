<?php

namespace App\Livewire\Athlete;

use App\Models\AthleteParent;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class AthleteGuardian extends Component
{
    use WithPagination;
    public $athlete;
    public $guardian;
    public $guardianId;
    public $first_name;

    public function mount()
    {
        $this->athlete=auth()->user()->athlete;

    }
    public function render()
    {
        $guardians=AthleteParent::where('athlete_id',$this->athlete->id)->paginate(5);
        return view('livewire.athlete.guardian.athlete-guardian',['guardians'=>$guardians]);
    }
      public function destroy(){

            AthleteParent::destroy($this->guardianId);
            session()->flash('message', 'Data berhasil Dihapus');
            return $this->redirect('/guardian',navigate:true);
        }
      public function delete($id){
            $this->guardian=AthleteParent::findorfail($id);
            $this->guardianId=$id;
            $this->first_name=$this->athlete->first_name;
            Flux::modal('delete-profile')->show();
        }
}
