<?php

namespace App\Livewire\Event;

use App\Models\Event;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class MyEvent extends Component
{
    use WithPagination;
    public $club;
    public function mount()
    {
        if(auth()->user()->role_id==5){
            $this->club = auth()->user()->club;
        }else{
            $this->club=0;
        }
    }
    public $keyword;
    public $nonActiveEvent;
    public function updatingKeyword(){
      $this->gotoPage(1);
    }

    public function render()
    {
        $events = Event::where("name","LIKE","%$this->keyword%")->where('club_id',$this->club->id)->orderBy('status')->paginate(5);
        $this->nonActiveEvent=Event::where("name","LIKE","%$this->keyword%")->where('club_id',$this->club->id)->where('status',0)->count();
        return view('livewire.event.my-event',[
            'events' => $events,
        ]);
    }
    public function dateFormat($date)
    {
        return \Carbon\Carbon::parse($date)->format('d/m/Y H:i');
    }
    public $first_name;
    public $event;
     public function duplicate($id)
    {
        $event = Event::find($id);
        $newEvent = $event->replicate(); // duplikasi semua kolom kecuali primary key & timestamps
    $newEvent->name = $event->name . ' (Copy)'; // kamu bisa ubah data kalau perlu
    $newEvent->save();
    }
    public function delete($id)
    {
        $event = Event::find($id);
        $this->event=$event;
        $this->first_name=$event->name;
        Flux::modal('delete-event')->show();
    }

    public function destroy()
    {
        $this->event->delete();
        session()->flash('message', 'Event deleted successfully.');
        Flux::modal('delete-event')->close();
    }
    public function badgeStatus($status)
    {
        if ($status == 1) {
            return '<small class="inline-block px-3 py-1  font-medium text-white bg-blue-500 rounded-full mb-2">Berlangsung</small>';
        } elseif ($status == 2) {
            return '<small class="inline-block px-3 py-1  font-medium text-white bg-green-500 rounded-full mb-2">Sedang Berlangsung</small>';
        } elseif ($status == 0) {
            return '<small class="inline-block px-3 py-1  font-medium text-white bg-red-500 rounded-full mb-2">Tidak aktif</small>';
        }
    }
}
