<?php

namespace App\Livewire\Athlete;

use App\Models\Athlete;
use Flux\Flux;
use Livewire\Component;
use Livewire\Attributes\On;
// use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithFileUploads as LivewireWithFileUploads;

class Create extends Component
{
    protected $listeners = ['openEditModal'];
    public $athletes;

    public function mount(){
        $this->athletes = Athlete::all();
    }

#[On('resetData')]

    public function resetData($athlete)
    {
    }
    public function edit($id)
    {
        $this->dispatch('editModal',$id);


    }
    public function delete($id)
    {
        $this->dispatch('deleteModal',$id);

    }


    // public function update()
    // {
    //     $this->validate([
    //         'name' => 'required',
    //         'nik' => 'required|unique:athletes,nik,' . $this->athleteId,
    //         'photo' => 'image|max:1024|nullable', // 1MB Max
    //         'dob' => 'required|date',
    //         'phone' => 'required',
    //         'email' => 'required|email|unique:athletes,email,' . $this->athleteId,
    //         'nation' => 'required',
    //         'province' => 'required',
    //         'city' => 'required',
    //         'address' => 'required',
    //         'type' => 'required',
    //     ]);

    //     $athlete = Athlete::findOrFail($this->athleteId);
    //     $athlete->name = $this->name;
    //     $athlete->nik = $this->nik;

    //     // Jika ada foto baru, simpan foto dan perbarui path
    //     if ($this->photo) {
    //         // Hapus foto lama jika ada
    //         if ($athlete->photo) {
    //             // \Storage::disk('public')->delete($athlete->photo);
    //         }
    //         $athlete->photo = $this->photo->store('photos', 'public');
    //     }

    //     $athlete->dob = $this->dob;
    //     $athlete->phone = $this->phone;
    //     $athlete->email = $this->email;
    //     $athlete->nation = $this->nation;
    //     $athlete->province = $this->province;
    //     $athlete->city = $this->city;
    //     $athlete->address = $this->address;
    //     $athlete->type = $this->type;

    //     $athlete->save();

    //     session()->flash('message', 'Athlete updated successfully.');
    //     $this->resetFields();
    //     $this->athletes = Athlete::all(); // Refresh the list
    // }
    public function render()
    {
        return view('livewire.athlete.create');
    }
      public $currentStep = 1;

    public function nextStep()
    {
        $this->currentStep++;
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

}
