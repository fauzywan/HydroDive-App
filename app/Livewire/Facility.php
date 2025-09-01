<?php

namespace App\Livewire;

use Livewire\Component;

class Facility extends Component
{
    public $newFacilityName;
    public $facilityName;
    public $newFacilityIsNeeded = true;
    public function render()
    {
        $facilities = \App\Models\Facility::paginate(5);
        return view('livewire.facility',[
            'facilities' => $facilities,
        ]); 
    }
    public function addFacility()
    {
        $this->validate([
            'newFacilityName' => 'required|string|max:255',
        ]);

        \App\Models\Facility::create([
            'name' => $this->newFacilityName,
            'is_needed' => $this->newFacilityIsNeeded,
        ]);

        session()->flash('message', 'Fasilitas berhasil ditambahkan.');
        $this->reset('newFacilityName', 'newFacilityIsNeeded');
    }
    public function editFacility($id)
    {
        $facility = \App\Models\Facility::find($id);
        $this->facilityName = $facility->name;
        $this->newFacilityIsNeeded = $facility->is_needed;
    }
    public function updateFacility($id)
    {
        $this->validate([
            'facilityName' => 'required|string|max:255',
        ]);

        $facility = \App\Models\Facility::find($id);
        $facility->update([
            'name' => $this->facilityName,
            'is_needed' => $this->newFacilityIsNeeded,
        ]);

        session()->flash('message', 'Fasilitas berhasil diperbarui.');
        $this->reset('facilityName', 'newFacilityIsNeeded');
    }
    public function deleteFacility($id)
    {
        $facility = \App\Models\Facility::find($id);
        $facility->delete();

        session()->flash('message', 'Fasilitas berhasil dihapus.');
    }
}
