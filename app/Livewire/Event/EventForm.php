<?php

namespace App\Livewire\Event;

use App\Models\Club as CLUBS;
use App\Models\Event;
use App\Models\EventDate;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class EventForm extends Component
{
    use WithFileUploads;
    public $event;
    public $formType = "save"; // 'save' or 'update'
    public $formStage = 0;
    public $nextButton = "Next";
    public $prevButton = "Back";
    public $photoPrev = '';

    public $club_id=1;
    public $name;
    public $start_event;
    public $end_event;
    public $poster;
    public $location;
    public $status =1;
    public $description;
    public $competition_start;
    public function mount($event = null)
    {

        $this->competition_start=date('Y-m-d H:i:s');
        if ($event!=null) {
            if(!is_object($event))
            {
                $event = Event::find($event);
            }
            $this->event = $event;
            $this->formType = "update";
            $this->fill([
                'club_id' => $event->club_id,
                'name' => $event->name,
                'competition_start' => $event->competition_start,
                'competition_end' => $event->competition_start,
                'location' => $event->location,
                'status' => $event->status,
                'description' => $event->description,
            ]);
        }
    }

    public function prevForm()
    {
        if ($this->formStage > 0) {
            $this->formStage--;
            $this->nextButton = "Next";
        }
    }
    public function back(){
        if(auth()->user()->role_id == 5){
            return $this->redirect('/club/my-event', navigate: true);
        }
        return $this->redirect('/event', navigate: true);
    }
    public function nextForm()
    {
        if ($this->formStage < 2) {
            $this->formStage++;
            $this->nextButton = $this->formStage == 2 ? "Save" : "Next";
        }
    }

    public function nextnPrev($type = 0)
    {
        if ($type === 0 && $this->formStage > 0) {
            $this->formStage--;
        } elseif ($type === 1 && $this->formStage < 2) {
            $this->formStage++;
        }
        $this->nextButton = $this->formStage == 2 ? "Save" : "Next";
    }
public function update()
{


    if (!$this->event) {
        session()->flash('error', 'Event tidak ditemukan.');
        return;
    }


        if($this->poster!= null && $this->poster != ''){
            if($this->event->poster!=""){
                  Storage::disk('public')->delete('event/poster/' . $this->event->poster);
                $parts = explode('.', $this->event->poster);
                array_pop($parts);
                $filenameWithoutExt = implode('.', $parts);
                $extension = $this->poster->getClientOriginalExtension();
                $pst = $filenameWithoutExt . '.' . $extension;
            }else{
                $pst = $this->club_id ."_event_".date('Ymd').'.' . $this->poster->getClientOriginalExtension();
            }
            $path = $this->poster->storeAs('event/poster/', $pst, 'public');
        }

    $eventData = [
        'name' => $this->name,
        'competition_start' => $this->competition_start ,
        'competition_end' => $this->competition_start ,
        'location' => $this->location,
        'is_limited' =>0,
        'club_id' => $this->club_id,
        'description' => $this->description,
    ];

    $this->event->update($eventData);
    session()->flash('success', 'Event berhasil diperbarui!');

    $this->resetForm();

    if (auth()->user()->role_id == 5) {
        return $this->redirect('/club/event', navigate: true);
    }
    return $this->redirect('/event', navigate: true);
}
    public function save()
    {
        $pst="";
        $rules=[
            'name'=>'required',
            'competition_start'=>'required',
            'location'=>'required',
        ];

        $eventData = [
            'name' => $this->name,
            'competition_start' => $this->competition_start,
            'competition_end' => $this->competition_start,
            'location' => $this->location,
            'club_id' => $this->club_id,
            'status' => 0,
            'is_limited' => 0,
            'description' => $this->description,
        ];
            if($this->poster!= null && $this->poster != ''){
            $rules['poster'] = 'image|mimes:jpeg,png,jpg,gif,svg';
        }

        $this->validate($rules);
        if($this->poster!= null && $this->poster != ''){
            $pst = $this->club_id ."_event_".date('Ymd').'.' . $this->poster->getClientOriginalExtension();
            $path = $this->poster->storeAs('event/poster/', $pst, 'public');
             $eventData['poster'] = $pst;
        }
        if ($this->formType === 'update' && $this->event) {
            $this->event->update($eventData);
            session()->flash('success', 'Event updated successfully!');
        } else {
            $eventData['poster'] = $pst;
            $event=Event::create($eventData);
            session()->flash('success', 'Event created successfully!');
        }
        if(auth()->user()->role_id == 5){
            return $this->redirect('/club/my-event', navigate: true);
        }
        return $this->redirect('/event', navigate: true);
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->formStage = 0;
        $this->name = '';
        $this->start_event = '';
        $this->end_event = '';
        $this->location = '';
        $this->description = '';
        $this->status = 0;
        $this->formType = "save";
    }

    public function render()
    {
        $clubs = CLUBS::all();

            $user = auth()->user();

            $user = auth()->user();

        if ($user->role_id == 5 && $user->club) {
            $this->club_id = $user->club->id;
            $clubs = CLUBS::where('id', $this->club_id)->get();
        }



        return view('livewire.event.event-form', [
            'clubs' => $clubs,
        ]);
    }
}
