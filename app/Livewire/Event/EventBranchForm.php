<?php

namespace App\Livewire\Event;

use App\Models\Category;
use App\Models\EventBranch;
use App\Models\EventHeat;
use App\Models\EventNumber;
use App\Models\GroupAge;
use Carbon\Carbon;
use Flux\Flux;
use Livewire\Component;

class EventBranchForm extends Component
{
    public $formType="save";
    public $branchSearch;
    public $keyword;
    public $name;
    public $category_id;
    public $isFinal=0;
    public $inputNewAge=0;
    public $ageGroup;
    public $minimal_age;
    public $group_age_id=0;
    public $maximal_age;
    public $registration_fee;
    public $capacity;
    public $capacity_per_club=1;
    public $description;
    public $event_id;
    public $name_branch;
    public $group_name;
    public $event;
    public $branch;
    public $eventNumber;
    public $line=8;

    public function updatedGroupAgeId()
    {
        $newAge=0;
        if($this->group_age_id==0)
        {
            $newAge=1;
            $this->minimal_age="";
            $this->maximal_age="";
        }
        $this->inputNewAge=$newAge;
    }
    public function mount($id){

        $this->eventNumber=EventNumber::find($id);

        if(request()->segment(3)=="edit"){
            $this->branch=EventBranch::find($id);
         $this->eventNumber=$this->branch->eventNumber;

            $this->group_age_id=$this->branch->group_age_id;
            $this->inputNewAge=0;

            $this->event=$this->branch->eventNumber->event;
            $this->formType="update";
            $this->name=$this->branch->name;
            $this->maximal_age =Carbon::parse($this->branch->max_age)->age;
            $this->minimal_age =Carbon::parse($this->branch->min_age)->age ;
            $this->capacity=$this->branch->capacity;
            $this->isFinal=$this->branch->is_final;
            $this->line=$this->branch->line;
            $this->capacity_per_club=$this->branch->capacity_per_club;
            $this->description=$this->branch->description;
            $this->registration_fee=$this->branch->registration_fee;
            $this->event_id=$this->event->id;
        }
        $en=$this->eventNumber;
        $this->ageGroup=GroupAge::all();
        $this->inputNewAge=1;
        if($this->ageGroup->count()>0)
        {
        $this->ageGroup= $this->ageGroup->filter(function($ag) use($id){
           return EventBranch::where('group_age_id',$ag->id)->where('event_number_id',$id)->count()<2;
        });
        }
        if($this->ageGroup->count()>0)
        {
                    if(request()->segment(3)!="edit"){
                            $this->group_age_id=$this->ageGroup->first()->id;
                    }
            $this->inputNewAge=0;
        }

        $no=$this->eventNumber->number;
        $this->name_branch=$this->eventNumber->category->description;
        $this->name="$no";
        $this->event_id=$id;

    }


    public function updatedIsFinal()
    {
        if($this->isFinal==1)
        {
            $this->capacity=8;
            $this->capacity_per_club=1;
        }
        else{
            $this->capacity="";
            $this->capacity_per_club="";

        }
    }
    public function render()
    {

            return view('livewire.event.event-branch-form');
    }

    public function update()
    {
          $this->validate([
        'name' => 'required|string|max:255',
        'capacity' => 'required|integer|min:0',
        'capacity_per_club' => 'required|integer|min:0',
        'registration_fee' => 'required|integer|min:0',
    ]);

    if ($this->minimal_age > $this->maximal_age) {
        $this->addError('minimal_age', 'Usia minimal tidak boleh lebih besar dari usia maksimal.');
    }
      if($this->group_age_id==0){
        $groupAge=GroupAge::create([
            'name'=>$this->group_name,
            'min_age'=>$this->minimal_age,
            'max_age'=>$this->maximal_age
        ]);
        $this->group_age_id=$groupAge->id;
    }else{
        $Ga=GroupAge::find($this->group_age_id);
        $this->minimal_age=$Ga->min_age;
        $this->maximal_age=$Ga->max_age;
    }
     $minDate = now()->subYears($this->minimal_age)->format('Y-m-d');
     $maxDate = now()->subYears($this->maximal_age)->format('Y-m-d');

    $this->branch->update([
        'name' => $this->name,
        'capacity' => $this->capacity,
        'capacity_per_club' => $this->capacity_per_club,
        'registration_fee' => $this->registration_fee,
        'description' => $this->description,
        'group_age_id' =>$this->group_age_id,

    ]);

    session()->flash('success', 'Cabang berhasil diperbarui.');
    $eventID=$this->event_id;
    return $this->redirect("/number/$eventID/list",navigate:true);
}
public function save()
{

    $this->validate([
        'name' => 'required',
        'registration_fee' => 'required|numeric|min:0',
        'capacity' => 'required|integer|min:0',
        'capacity_per_club' => 'required|integer|min:0',
        'description' => 'nullable|string',
    ]);

    // Konversi usia ke tanggal berdasarkan hari ini
    if($this->group_age_id==0){
        $groupAge=GroupAge::create([
            'name'=>$this->group_name,
            'min_age'=>$this->minimal_age,
            'max_age'=>$this->maximal_age
        ]);
                $this->group_age_id=$groupAge->id;
    }else{
        $Ga=GroupAge::find($this->group_age_id);
        $this->minimal_age=$Ga->min_age;
        $this->maximal_age=$Ga->max_age;
    }
    $maxDate = now()->subYears($this->maximal_age)->format('Y-m-d'); // maximal_age jadi batas paling tua
    $minDate  = now()->subYears($this->minimal_age)->format('Y-m-d'); // minimal_age jadi batas paling muda
    $branch=\App\Models\EventBranch::create([
        'event_number_id' => $this->eventNumber->id,
        'name' => $this->name,
        'capacity' => $this->capacity,
        'current_capacity' =>0,
        'group_age_id' =>$this->group_age_id,
        'capacity_per_club' => $this->capacity_per_club,
        'description' => $this->description,
        'registration_fee' => $this->registration_fee,
        'status'=>1,
        'line'=>$this->line,
        'is_final'=>$this->isFinal
    ]);
    if($this->isFinal==1)
{

    EventHeat::create([
        'event_id'=>$this->eventNumber->event->id,
        'branch_id'=>$branch->id,
            'name'=>"FINAL",
            'capacity'=>$this->line,
            'best_of'=>0,
            'heat_total'=>1,
            'from_rank'=>1,
            'to_rank'=>8,
            'is_final'=>1,
            'is_sp'=>0,
            'round'=>1,
            'status'=>0,
        ]);
    }else{
            EventHeat::create([
        'event_id'=>$this->eventNumber->event->id,
        'branch_id'=>$branch->id,
            'name'=>"PRELIM",
            'capacity'=>$this->capacity,
            'best_of'=>0,
            'heat_total'=>1,
            'from_rank'=>1,
            'to_rank'=>$this->capacity,
            'is_final'=>0,
            'is_sp'=>0,
            'round'=>1,
            'status'=>0,
        ]);

    }
        $evnbnrid=$this->eventNumber->id;
    session()->flash('success', 'Event branch successfully created.');
      return $this->redirect("/number/$evnbnrid/list",navigate:true);

    }
}
