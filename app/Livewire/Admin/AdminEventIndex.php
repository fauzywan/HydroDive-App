<?php

namespace App\Livewire\Admin;

use App\Models\Event;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class AdminEventIndex extends Component
{
        use WithPagination;
    public $perpage = 5;
    public $poster;
    public $navigations = 1;
    public $navActive = 1;
    public $keyword = ''; // ✅ Tambah properti untuk search

    public function show($no)
    {
        $this->navActive = $no;
        $this->resetPage();
    }
    public $eventBerlangsung;
    public function mount()
    {
        $this->eventBerlangsung = Event::where('status', 1)->first();
        $this->navigations = [
            ["no" => 1, "name" => "Semua Event"],
            ["no" => 2, "name" => "Event Saya"],
        ];
        $this->perpage = \App\Models\settings::first()->data_per_page;
    }

    public function showPoster($poster)
    {
        $url = 'storage/event/poster/';
        Flux::modal("modal-poster")->show();
        if ($poster == null || $poster == '') {
            $poster = 'default.jpg';
            $url = 'storage/';
        }
        $this->poster = asset($url . $poster);
    }
    public function GoToActiveEvent($id)
    {
     return $this->redirect("event/$id/detail",navigate: true);
    }
    public function eventActive($id)
    {
        // kalau mau toggle status bisa diaktifkan kembali
        // $event = Event::findOrFail($id);
        // $event->update(['status' => !$event->status]);
        // session()->flash('message', 'Status event berhasil diperbarui.');
    }

    public function updatingKeyword()
    {
     $this->gotoPage(1); // ✅ Supaya balik ke page 1 kalau ada search
    }

    public function render()
    {
        $query = Event::query();

        if ($this->navActive == 2) {
            $query->where('club_id', 1);
        }

        // ✅ Tambah filter search
        if ($this->keyword) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->keyword . '%')
                  ->orWhereHas('club', function ($q2) {
                      $q2->where('name', 'like', '%' . $this->keyword . '%');
                  });
            });
        }

        $events = $query->paginate($this->perpage);

        return view('livewire.admin.admin-event-index', [
            'events' => $events
        ]);
    }
}
