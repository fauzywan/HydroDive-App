<?php

namespace App\Livewire\Coach;

use App\Models\coachLicense as Licenses;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CoachLicense extends Component
{
    use WithFileUploads;
    public $first_name;
    public $coachSearch;
    public $coach;
    public function mount()
    {
        $this->coach=auth()->user()->coach;
    }
    public $license;
    public $name;
    public $license_file;
    public $modal_type=1;
    public function saveLicense()
    {

        $loop=Licenses::where('coach_id',$this->coach->id)->count();
        $file_name =  now()->format('Ymd_His');
        $filename =$file_name."_". $this->coach->id . "_$loop." . $this->license_file->getClientOriginalExtension();

        $path = $this->license_file->storeAs('coach/licenses', $filename, 'public');
        $loop++;

        Licenses::create(['name'=>$this->name,'filename'=>$filename,'coach_id'=>auth()->user()->coach->id]);
        session()->flash('message', 'Berhasil Menambahkan Lisensi');
        $this->redirect('/coach/license',navigate:true);
    }
    public function delete($id)
    {
        $this->license=Licenses::find($id);
        $this->first_name=$this->license->name;
        Flux::modal('delete-profile')->show();
    }

    public function destroy()
    {
        Storage::disk('public')->delete('coach/licenses/'.$this->license->filename);
        $this->license->delete();
        session()->flash('message', 'Data berhasil ditambahkan');
        return $this->redirect('/coach/license', navigate: true);

    }

    public function addLincense()
    {
        $this->modal_type=2;
      $this->license_file="";
       $count= Licenses::where("coach_id",auth()->user()->coach->id)->count();
        Flux::modal('modal-license')->show();
    }
    public function edit($id)
    {
        $this->license=Licenses::find($id);
        $this->name=$this->license->name;
        Flux::modal('license-modal')->show();

    }
    public function updateLicense(){
        $this->modal_type=1;
        $this->license->update(['name'=>$this->name]);
        session()->flash('message', 'Profile photo updated successfully.');
        $this->redirect('/coach/license',navigate:true);
    }
    public function render()
    {
        $licenses=Licenses::where('coach_id',$this->coach->id)->get();
        return view('livewire.coach.coach-license',['licenses'=>$licenses]);
    }
}
