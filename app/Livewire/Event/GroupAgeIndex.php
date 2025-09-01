<?php

namespace App\Livewire\Event;

use App\Models\GroupAge;
use App\Models\settings;
use Flux\Flux;
use Livewire\Component;

class GroupAgeIndex extends Component
{
    public $formType = "add";
    public $group_name;
    public $name;
    public $min_age;
    public $GroupAges=[];
    public $max_age;
    public $perPage = 10;
    public function mount()
    {

        $this->perPage= settings::first()->data_per_page;
    }
    public function update()
    {
        $rules=[
                "min_age"=> 'required|numeric',
                "max_age"=> 'required|numeric'];
        $this->validate($rules);
    $groupAge =$this->selectedGroupAge;
            if($groupAge->name==$this->name){
                $rules=["name"=> 'required|unique:group_ages,name'];
            }
    $groupAge->update([
        'name' => $this->name,
        'min_age' => $this->min_age,
        'max_age' => $this->max_age,
    ]);

    session()->flash('message', 'Group Age updated successfully!');
    $this->resetForm();
    Flux::modal('form-modal')->close();
    }
    public function add()
    {
        $rules=["name"=> 'required|unique:group_ages,name',
                "min_age"=> 'required|numeric',
                "max_age"=> 'required|numeric'];
        $this->validate($rules);
         GroupAge::create([
            'name' => $this->name,
            'min_age' => $this->min_age,
            'max_age' => $this->max_age,
        ]);
        session()->flash('message', 'Group Age added successfully!');
        $this->resetForm();
        Flux::modal('form-modal')->close();
    }

    public function resetForm()
    {
        $this->name="";
        $this->min_age="";
        $this->max_age="";
    }
    public $selectedGroupAge;
    public function edit($id)
    {
        $this->selectedGroupAge=GroupAge::find($id);
        Flux::modal('form-modal')->show();
            $this->name=$this->selectedGroupAge->name;
            $this->min_age=$this->selectedGroupAge->min_age;
            $this->max_age=$this->selectedGroupAge->max_age;
            $this->formType="update";
            Flux::modal('form-modal')->show();
    }
    public function addGroup()
    {
        Flux::modal('form-modal')->show();
        $this->formType="add";
    }
    public function delete($id,$name)
    {
        Flux::modal('confirm-modal')->show();
        $this->group_name=$name;
    }
    public function render()
    {

        $groupAges = \App\Models\GroupAge::paginate($this->perPage ?? 10);
        return view('livewire.event.group-age-index', [
            'groupAges' => $groupAges,
        ]);
    }
}
