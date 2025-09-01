<?php

namespace App\Livewire\Event;

use App\Models\Event;
use App\Models\EventClub;
use Livewire\Component;

class EventIndex extends Component
{
    public $club;
    public $navigations=1;
    public function mount()
    {
           $this->navigations=[
                ["no"=>1,"name"=>"Aktif"],
                ["no"=>0,"name"=>"Tidak Aktif"],
            ];
        if(auth()->user()->role_id==5){
            $this->club = auth()->user()->club;
        }else{
            $this->club=\App\Models\Club::find(1);
        }
    }
    public $events;
    public function show($no)
    {
         $this->navActive=$no;

    }
    public $navActive=1;
    public function render()
    {
        if($this->navActive==1){

            $this->events = Event::where('status','!=',0)->orderBy('status')->get();
        }else{
            $this->events = Event::where('status',0)->orderBy('status')->get();
        }
        return view('livewire.event.event-index');
    }
    public function checkIsRegistered($start,$end,$event_id)
    {
        $event=Event::find($event_id);
        if($event->status==1){
            $end=date('Y-m-d',strtotime($end));
            $start=date('Y-m-d',strtotime($start));
    return(EventClub::where('event_id',$event_id)
         ->where('club_id',$this->club->id)
         ->where('created_at',">=",$start)
         ->where('created_at',"<=",$end)
         ->
         count()
        );
    }
}
    public function registerEvent($id)
    {
        if(EventClub::where('event_id',$id)->where('club_id',$this->club->id)->where('status','!=',-1)->where('status','!=',0)->exists()){
            session()->flash('message', 'You have already registered for this event.');
            return;
        }

       $event= EventClub::create([
            'event_id' => $id,
            'club_id' => $this->club->id,
            'status' => 2,
        ]);
        session()->flash('message', 'Registrasi berhasil, Tunggu Penyelenggara menyetujui');
    }
}
