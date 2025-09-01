<?php

namespace App\Livewire\Athlete;

use App\Models\Athlete;
use App\Models\Club;
use App\Models\User;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
class ModalAthlete extends Component
{
    use WithFileUploads;
    public $club_id="Belum Terdaftar";
    public $modalText="Add";
    public $modalSubText="Create New Athlete Data";
    public $athleteId;
    public $athlete;
    public $formType="save";
    public $isEditMode = false;


    public function mount(){
        if(auth()->user()->role_id==5){
            $this->club_id=auth()->user()->club->id;
        }
    }
    public function resetFields()
    {
        $this->athletes="";
        $this->first_name="";
        $this->last_name="";
        $this->identity_number="";
        $this->dob="";
        $this->gender="Male";
        $this->province="";
        $this->city="";
        $this->address="";
        $this->email="";
        $this->phone="";
        $this->photo="";
        $this->nation="";
        $this->type="";
        $this->club_id=1;}

    public $athletes;
    public $first_name;
    public $last_name="";
    public $identity_number;
    public $dob;
    public $gender="male";
    public $province;
    public $city;
    public $address;
    public $email;
    public $phone;
    public $photo;
    public $nation;
    public $type;


    public function save()
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'identity_number' => 'required|string|max:16',
            'photo' => 'nullable|image|max:2048',
            'dob' => 'required|date',
            'phone' => 'required|string|max:15',
            'gender' => 'nullable|string',
            'nation' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'club_id' => 'required',
           'email' => 'required|email|unique:athletes,email'
        ];


        $this->validate($rules);
        $dobParts = explode('-', $this->dob);
        if (count($dobParts) === 3) {
            $year = $dobParts[0];
            $month = $dobParts[1];
            $day = $dobParts[2];

            if (strlen($year) === 5) {
                $year = substr($year, 0, 4);
            }

            $this->dob = $year . '-' . $month . '-' . $day;
        }

        $filename="default.jpg";
        if($this->photo){
            $filename = md5($this->first_name) . '.' . $this->photo->getClientOriginalExtension();
            $path = $this->photo->storeAs('athlete', $filename, 'public');
        }
        $this->club_id=Club::where('nick',$this->club_id)->first()->id;



        Athlete::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'identity_number' => $this->identity_number,
            'photo' => $filename,
            'dob' => $this->dob,
            'phone' => $this->phone,
            'email' => $this->email,
            'gender' => strtolower($this->gender),
            'nation' => $this->nation,
            'province' => $this->province,
            'city' => $this->city,
            'address' => $this->address,
            'type' => "individual",
            'club_id' => $this->club_id,
        ]);
        User::create([
            'name' => $this->first_name,
            'email' => $this->email,
            'password' => password_hash('123', PASSWORD_DEFAULT),
            'role_id' => 3,
        ]);

        session()->flash('message', 'Data atlet berhasil ditambahkan.');
        \Flux\Flux::modal('athlete-modal')->close();

        return $this->redirect('athlete', navigate: true);
        //   $this->reset();


    }


    public $formStage=0;
    public $nextButton="Next";
    public $prevButton="Back";
    public $photoPrev='';
    public function prevForm(){
        if($this->formStage>0){
        $this->formStage-=1;
        $this->nextButton="Next";
        }
    }
    public function nextForm(){
        if($this->formStage<=2){
            $this->formStage+=1;
            $this->nextButton="Next";
        }
        if($this->formStage==2){
            $this->prevButton="Back";
            $this->nextButton="Save";
        }

    }
    public function changeFormType($type){
        $this->formType=$type;
    }
    public function render()
    {
        return view('livewire.athlete.modal-athlete',['clubs'=>Club::all()]);
    }
     #[On('editModal')]
    public function edit($id){
    $this->changeFormType('update');
        $this->athlete=Athlete::findorfail($id);

        $this->fillForm();
        Flux::modal('athlete-modal')->show();
    }
    public function update(){
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'dob' => 'required|date',
            'phone' => 'required|string|max:15',
            'gender' => 'nullable|string',
            'nation' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'club_id' => 'required',
        ];
        if(auth()->user()->role_id!=5){

            $this->club_id=Club::where('nick',$this->club_id)->first()->id;
        }


        if ($this->email !== $this->athlete->email) {
            $rules['email'] = 'required|email|unique:athletes,email';
        }

        $this->validate($rules);

        if($this->gender==null){
            $this->gender="Male";
        }
        $this->gender=strtolower($this->gender);

        $filename=$this->athlete->photo;
        if($this->photo){
            $filename = md5($this->first_name) . '.' . $this->photo->getClientOriginalExtension();
            $path = $this->photo->storeAs('athlete', $filename, 'public');
        }
        if($this->identity_number!=$this->athlete->identity_number){
            $this->athlete->update(['identity_number'=>$this->identity_number]);
        }
        if($this->email!=$this->athlete->email){
            $this->athlete->update(['email'=>$this->email]);
        }
        $this->athlete->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'photo' => $filename,
                'dob' => $this->dob,
                'phone' => $this->phone,
                'gender' => $this->gender,
                'nation' => $this->nation,
                'province' => $this->province,
                'city' => $this->city,
                'address' => $this->address,
                'type' => 'individual',
                'club_id'=>$this->club_id
            ]);

            $this->athlete=[];
            session()->flash('message', 'Data berhasil Diubah');

            return $this->redirect('profile',navigate:true);
    }

    public function fillForm(){
        $this->first_name=$this->athlete->first_name;
        $this->last_name=$this->athlete->last_name;
          $this->identity_number=$this->athlete->identity_number;
          $this->dob=$this->athlete->dob;
          $this->phone=$this->athlete->phone;
          $this->email=$this->athlete->email;
          $this->gender=$this->athlete->gender;
          $this->nation=$this->athlete->nation;
          $this->province=$this->athlete->province;
          $this->city=$this->athlete->city;
          $this->address=$this->athlete->address;
  }
    public function destroy(){
        Athlete::destroy($this->athleteId);
        session()->flash('message', 'Data berhasil Dihapus');

        return $this->redirect('/athlete',navigate:true);


    }
    #[On('deleteModal')]
    public function delete($id){
        $this->athlete=Athlete::findorfail($id);
        $this->athleteId=$id;
        $this->first_name=$this->athlete->name;
        // Flux::modal('delete-modal')->show();
    }
}
