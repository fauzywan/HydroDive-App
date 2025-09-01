<?php

namespace App\Livewire\Coach;

use App\Models\Club;
use App\Models\Coach;
use App\Models\CoachCategory;
use App\Models\coachLicense;
use App\Models\settings;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class CoachForm extends Component
{
    use WithFileUploads;
    public $coach;
    public function update()
    {

        $rule=[
            'category'=>'required',
            'city'=>'required',
            'dob'=>'required',
            'pob'=>'required',
            'gender'=>'required',
            'name'=>'required',
            ];
        $this->validate($rule);
        if($this->email!=$this->coach->email){
            $this->coach->update(['email'=>$this->email]);
        }
        if ($this->profile) {
            if($this->coach->profile!=""){
            Storage::disk('public')->delete('coach/' . $this->coach->profile);
            }
            $namaProfile=md5($this->coach->name) . '.' . $this->profile->getClientOriginalExtension();
            $this->profile->storeAs('coach', $namaProfile, 'public');

            $this->coach->update(['profile'=>$namaProfile]);

        }
        if (count($this->documents) > 0) {
            $count=0;

            foreach ($this->documents as $license) {

                $loop=coachLicense::where('coach_id',$this->coach->id)->count();
                $file_name =  now()->format('Ymd_His');
                $filename =$file_name."_". $this->coach->id . "_$loop." . $license->getClientOriginalExtension();

                $path = $license->storeAs('coach/licenses', $filename, 'public');
                $loop++;


                coachLicense::create([
                    'name' => $filename,
                    'filename'=>$filename,
                    'coach_id' => $this->coach->id,
                ]);
            }
        }
        $category=CoachCategory::where('name', $this->category)->first()->id ?? 1;
        $club=Club::where('nick', $this->club)->first();

        if($category==2){
            if($club->hoc!=$this->coach->id){
                Coach::find($club->hoc)->update(['coach_category_id'=>1]);
                $club->update(['hoc'=>$this->coach->id]);
            }

        }
        $this->coach->update([
            'name'=>$this->name,
            'gender'=>$this->gender,
            'city'=>$this->city,
            'dob'=>$this->dob,
            'pob'=>$this->pob,
            'coach_category_id'=>$category,
            'club_id'=>$club->id,
    ]);
    session()->flash('message', 'Data berhasil Ubah');

    if(auth()->user()->role_id==5){

        return $this->redirect('/club/coach', navigate: true);
    }
    return $this->redirect('/coach', navigate: true);
    }
    public $formType="save";
    public function mount($id=null)
    {
        $this->previousUrl=url()->previous();

        $this->formType="save";
        if($id){
            $this->formType="update";
            $coach= Coach::find($id);
            $this->coach=$coach;
            $this->name=$coach->name;
            $this->gender=$coach->gender ;
            $this->club=Club::find($coach->club_id)->nick;
            $this->pob=$coach->pob;
            $this->dob=$coach->dob;
            $this->city=$coach->city;
            $this->category=CoachCategory::find($coach->coach_category_id)->name;
            $this->email=$coach->email;
        }
    }
    public $profile;
    #[Rule('required')]
    public $name;

    #[Rule('required')]
    public $gender = "male";

    // #[Rule('required')]
    public $documents=[];
    public $club;

    #[Rule('required')]
    public $pob;

    #[Rule('required')]
    public $dob;

    #[Rule('required')]
    public $city;

    #[Rule('required|email|unique:coaches,email')]
    public $email;

    #[Rule('required')]
    public $category = "Belum Ditambahkan";

    public $licenses = [];

    public function render()
    {
        $clubs=Club::all();
        if(auth()->user()->role_id==5){
            $clubs=Club::where('id',auth()->user()->club->id)->get();
        }
        return view('livewire.coach.coach-form', [
            'categories' => CoachCategory::all(),
            'clubs' => $clubs,
        ]);
    }


    public function save()
    {
        $this->validate();
        $coc_id = CoachCategory::where('name', $this->category)->first()->id ?? 1;
        $club=Club::where('nick', $this->club)->first()->id ?? 1;
        if(auth()->user()->role_id==5){
            $club=auth()->user()->club->id;
        }
        if($this->profile){

            $namaProfile=md5($this->name) . '.' . $this->profile->getClientOriginalExtension();
            $this->profile->storeAs('coach', $namaProfile, 'public');
            $this->profile=$namaProfile;
        }else{
            $this->profile="";
        }

        $coach = Coach::create([
            'name' => $this->name,
            'pob' => $this->pob,
            'club_id' => $club,
            'city' => $this->city,
            'email' => $this->email,
            'dob' => $this->dob,
            'profile' => $this->profile,
            'gender' => $this->gender,
            'coach_category_id' => $coc_id,
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => password_hash(settings::first()->password_default, PASSWORD_DEFAULT),
            'role_id' => 4,
        ]);
        if (count($this->documents) > 0) {
            foreach ($this->documents as $license) {
                $loop=coachLicense::where('coach_id',$coach->id)->count();
                $file_name =  now()->format('Ymd_His');
                $filename =$file_name."_". $coach->id . "_$loop." . $license->getClientOriginalExtension();

                $path = $license->storeAs('coach/licenses', $filename, 'public');
                $loop++;
                coachLicense::create([
                    'name' => $filename,
                    'filename' => $filename,
                    'coach_id' => $coach->id,
                ]);
            }
        }
        session()->flash('message', 'Data berhasil ditambahkan');

        if(auth()->user()->role_id==5){

            return $this->redirect('/club/coach', navigate: true);
        }
        return $this->redirect('/coach', navigate: true);
    }
    public $previousUrl;
    public function back()
    {
        if(auth()->user()->role_id==4){

            return $this->redirect("/coach/profile",navigate:true);
        }
        if(auth()->user()->role_id==5){

            return $this->redirect("/club/coach",navigate:true);
        }
        return $this->redirect("/coach",navigate:true);
    }
}
