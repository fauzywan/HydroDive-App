<?php

namespace App\Livewire\Club;

use Livewire\Component;
use App\Models\ClubSchedule as Schedule;
use Flux\Flux;

class ClubSchedule extends Component
{
    public $day;
    public $time_start;
    public $time_end;
    public $location;
    public $desc;



    public $formType="save";
    public $modalType=1;
    public $club;
    public $scheduleId;
    public function destroy(){
        Schedule::destroy($this->scheduleId);
        session()->flash('message', 'Data berhasil Dihapus');

        return $this->redirect('/club/schedule',navigate:true);

    }
    public function delete($id){
        $this->modalType=1;
        $this->scheduleId=$id;
        $this->formType="destroy";
        Flux::modal('modal-schedule')->show();

    }
    public function update(){
        $rules = [
            'day' => 'required|integer|between:1,7',
            'time_start' => 'required',
            'time_end' => 'required|after:time_start',
            'location' => 'required|string|max:255',
        ];
        $this->validate($rules);

        $day=$this->day;
        Schedule::find($this->scheduleId)->update([
            'day'=>$day,
            'club_id'=>$this->club->id,
            'location'=>$this->location,
            "time_start"=>$this->time_start,
            "time_end"=>$this->time_end,
            "desc"=>$this->desc,
        ]);
        session()->flash('message', 'Data berhasil Diubah');

        return $this->redirect('/club/schedule',navigate:true);
    }
    public function edit($id){
        $this->scheduleId=$id;
        $schedule=Schedule::find($this->scheduleId);
        $this->modalType=2;
        $this->day=$schedule->day;
        $this->time_start=$schedule->time_start;
        $this->time_end=$schedule->time_end;
        $this->location=$schedule->location;
        $this->desc=$schedule->desc;
        $this->formType="update";
        Flux::modal('modal-schedule')->show();

    }
    public function addSchedule(){
        $this->modalType=2;
        $this->formType="save";
        Flux::modal('modal-schedule')->show();

    }
    public function save(){
        $rules = [
            'day' => 'required|integer|between:1,7',
            'time_start' => 'required|date_format:H:i:s',
            'time_end' => 'required|date_format:H:i:s|after:time_start',
            'location' => 'required|string|max:255',
        ];
        $this->validate($rules);

        $day=$this->day;
        Schedule::create([
            'day'=>$day,
            'club_id'=>$this->club->id,
            'location'=>$this->location,
            "time_start"=>$this->time_start,
            "time_end"=>$this->time_end,
            "desc"=>"",
        ]);
        session()->flash('message', 'Data berhasil Ditambahkan');

        return $this->redirect('/club/schedule',navigate:true);
    }
    public function mount(){
        if(auth()->user()->role_id==5){

            $this->club=auth()->user()->club;
        }else{
            $this->club=auth()->user()->coach->club;
        }
        $this->day=1;
        $this->time_start="08:00:00";
        $this->time_end="09:00:00";
        $this->location=$this->club->homebase;
    }
    public function render()
    {

        $schedules=Schedule::where('club_id',$this->club->id)->get();
        return view('livewire.club.club-schedule',['schedules'=>$schedules]);
    }

}
