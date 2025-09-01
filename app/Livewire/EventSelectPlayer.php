<?php

namespace App\Livewire;

use App\Models\Athlete;
use App\Models\EventAdministration;
use App\Models\EventHeat;
use App\Models\EventMatch;
use App\Models\EventMatchPlayer;
use Livewire\Component;

class EventSelectPlayer extends Component
{
        public $availableAthletes;
        public $event;
    public $heat;
    public $eventName;
    public $heatName;
    public $mode; // insert atau update
public $match; // kalau update, simpan match-nya
 public function DeleteAthlete($id){
        return $this->redirect("/event/$id/delete-player",navigate:true);
    }
    public function deleteAthleteFromMatch($administrationId)
{
    if ($this->mode !== 'update') {
        session()->flash('message', 'Hanya bisa menghapus atlet saat mode update.');
        return;
    }

    // Cari dan hapus di database
    $player = EventMatchPlayer::where('event_match_id', $this->match->id)
        ->where('administration_id', $administrationId)
        ->first();

    if ($player) {
        $player->delete();

        // Hapus dari array eventAthletes
        $this->eventAthletes = array_values(array_filter($this->eventAthletes, function($a) use ($administrationId) {
            return $a['administration_id'] != $administrationId;
        }));

        // Kembalikan ke availableAthletes
        $admin = EventAdministration::find($administrationId);
        if ($admin) {
            $this->availableAthletes->push([
                'id' => $admin->id,
                'athlete' => $admin->athlete,
            ]);
        }

        session()->flash('message', 'Athlete berhasil dihapus dari match.');
    } else {
        session()->flash('message', 'Athlete tidak ditemukan di match.');
    }
}

public function mount($id)
{

    // tentukan mode dari segment ke-3
    if(request()->segment(3) == 'select-player') {
        $this->mode = 'insert';
    } else {
        $this->mode = 'update';
    }



    if ($this->mode === 'update') {
        $this->match = EventMatch::find($id);
        $this->heat = $this->match->Heat;
        $this->heatName = $this->match->heat;

        $this->eventAthletes = $this->match->players
            ->map(fn($p) => [
                'administration_id' => $p->administration_id,
                'athlete' => $p->athlete,
                'lane' => $p->line,
            ])
            ->toArray();

        $selectedIds = collect($this->eventAthletes)->pluck('athlete.id');

        // availableAthletes = semua yg belum dipakai
        $this->availableAthletes = EventAdministration::where('status', 1)->where('event_branch_id', $this->heat->branch->id)
            ->get()
            ->reject(fn($admin) => $selectedIds->contains($admin->athlete->id))
            ->map(fn($admin) => [
                'id' => $admin->id,
                'athlete' => $admin->athlete,
            ])
            ->values();
    } else {
        $this->heat = EventHeat::find($id);
  $this->eventName = $this->heat->branch->eventNumber->number . ": " .
    $this->heat->branch->eventNumber->category->description;

    $end=$this->heat->event->competition_end;
if($this->heat->event->status==1){
    $end = date('Y-m-d H:i:s');
}
    $this->heatName = EventMatch::where('heat_id', $this->heat->id)
        ->where('created_at', '>=', $this->heat->event->competition_start)
        ->where('created_at', '<=', $end)
        ->count() + 1;
        // insert baru

        $selectedIds = collect($this->eventAthletes)->pluck('athlete.id');
        $this->availableAthletes = EventAdministration::where('status', 1)
        ->where('event_branch_id', $this->heat->branch->id)
            ->get()
            ->reject(fn($admin) => $selectedIds->contains($admin->athlete->id))
            ->map(fn($admin) => [
                'id' => $admin->id,
                'athlete' => $admin->athlete,
            ])->values();
          $this->availableAthletes = $this->availableAthletes->filter(function ($athlete) {
    foreach ($this->heat->matches as $m) {
        $exists = EventMatchPlayer::where('administration_id', $athlete['id'])
                                  ->where('event_match_id', $m->id)
                                  ->exists();

        if ($exists) {
            return false; // kalau sudah terdaftar di salah satu match, exclude
        }
    }
    return true; // kalau belum ada di match manapun
});
    }
}
    public function goBack()
    {
        if ($this->mode === 'update') {
            $id=$this->match->id ;
            return $this->redirect("/match/$id/play",navigate:true);
        }
        else{

            $id=$this->heat->branch->event_number_id;
            return $this->redirect("/number/$id/list-heat",navigate:true);
        }
    }
    public function render()
    {
        return view('livewire.event-select-player');
    }
    public $selectedAthlete;
public $eventAthletes = []; // list yang sudah dipilih
public function addAthleteToEvent()
{
    if ($this->selectedAthlete) {
        $admin = EventAdministration::find($this->selectedAthlete);

        // Tambahkan ke daftar eventAthletes
        $this->eventAthletes[] = [
            'administration_id' => $admin->id,
            'athlete' => $admin->athlete,
            'lane' => count($this->eventAthletes) + 1,
        ];

        // Hapus dari availableAthletes
        $this->availableAthletes = $this->availableAthletes
            ->reject(fn($a) => $a['id'] === $admin->id)
            ->values();

        $this->selectedAthlete = null;
        session()->flash('message', 'Athlete added successfully.');
    }
}

public function removeAthlete($index)
{
    $removed = $this->eventAthletes[$index];

    // Kembalikan ke availableAthletes dengan struktur yang sama
    $this->availableAthletes->push([
        'id' => $removed['administration_id'],
        'athlete' => $removed['athlete'],
    ]);

    unset($this->eventAthletes[$index]);
    $this->eventAthletes = array_values($this->eventAthletes);

    session()->flash('message', 'Athlete removed successfully.');
}
public function saveAthletes()
{
    if (empty($this->eventAthletes)) {
        session()->flash('message', 'Athlete belum dipilih.');
        return;
    }

    if ($this->mode === 'insert') {
        // INSERT baru
        $match = EventMatch::create([
            'heat_id' => $this->heat->id,
            'name' => $this->heat->name."-".$this->heat->branch->name." ".$this->heat->branch->age->showName()."- Heat ".($this->heatName),
            'heat' => $this->heatName,
            'start_time' => now(),
            'end_time' => now(),
            'status' => 1,
        ]);

        foreach ($this->eventAthletes as $athleteData) {
            $category_id = $match->Heat->branch->eventNumber->category_id;

            EventMatchPlayer::create([
                'event_match_id'   => $match->id,
                'category_id'      => $category_id,
                'administration_id'=> $athleteData['administration_id'],
                'athlete_id'       => $athleteData['athlete']->id,
                'club_id'          => $athleteData['athlete']->club_id ?? null,
                'status'           => 1,
                'line'             => $athleteData['lane'],
            ]);
        }

        $this->heat->update(['status' => 1,'round'=> $this->heat->round+1]);
        session()->flash('message', 'Event match dan players berhasil disimpan.');

    } else {
        // UPDATE → cek satu²
        $existingPlayers = EventMatchPlayer::where('event_match_id', $this->match->id)->get();
        $category_id = $this->match->Heat->branch->eventNumber->category_id;

        foreach ($this->eventAthletes as $athleteData) {
            $existing = $existingPlayers->firstWhere('administration_id', $athleteData['administration_id']);

            if ($existing) {
                // Sudah ada → update line
                $existing->update([
                    'line' => $athleteData['lane'],
                ]);
            } else {
                // Belum ada → create baru
                EventMatchPlayer::create([
                    'event_match_id'   => $this->match->id,
                    'category_id'      => $category_id,
                    'administration_id'=> $athleteData['administration_id'],
                    'athlete_id'       => $athleteData['athlete']->id,
                    'club_id'          => $athleteData['athlete']->club_id ?? null,
                    'status'           => 1,
                    'line'             => $athleteData['lane'],
                ]);
            }
        }

        session()->flash('message', 'Event match players berhasil diperbarui.');
    }

    $id = $this->heat->branch->event_number_id;
    return $this->redirect("/number/$id/list-heat", navigate: true);
}
}
