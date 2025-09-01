<?php

namespace App\Livewire\Athlete;

use App\Models\Athlete;
use App\Models\athleteClub;
use App\Models\AthleteMigrationClub;
use App\Models\AthleteMirationClub;
use App\Models\AthleteParent;
use App\Models\Club;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class AthleteProfile extends Component
{
    use WithFileUploads;
    public $formStage=1;
    public $formShow=1;
    public $migrationRequests;
    public $athlete;
    public $photo=null;
    public $navActive = 1;


    public $navigations = [];


    public function show($no){
        $this->navActive=$this->formShow=$no;
        if($no==5)
        {
             $this->migrationRequests = AthleteMigrationClub::get();
        }
    }

    public function modalChange($type)
    {
        if($type==1){
            $this->modalClub=["title"=>"Detail Klub",
            "type"=>1];
        }
        else{
            $this->modalClub=["title"=>"Request Migrasi Klub",
            "type"=>2];
        }
    }

    public function mount($id=null)
    {
$this->modalChange(1);
        $this->navigations = [
            ["no" => 1, "name" => "Profile"],
            ["no" => 2, "name" => "Contact"],
            ["no" => 3, "name" => "Club"],
            ["no" => 4, "name" => "Parents"],
            ["no" => 5, "name" => "Migration Club"],
            ["no" => 6, "name" => "History"],
        ];
        if($id){
            $this->role_id=5;
            $this->athlete=Athlete::find($id);

        }else{

            $this->athlete=Athlete::where("email",auth()->user()->email)->first();
        }
        $this->clubDetail= $this->athlete->clubs->first()->club;


    }

    public $clubs=[];
    public $modalClub;
    public $clubDetail;
    public $old_club;
    public $new_club;
    public $new_club_id;
    public $keyword;
    public $reason;
    public $clubsByKeyword;
    public $requestClub;
    public $role_id=3;
    public function submitMigrationRequest()
    {

        if(auth()->user()->role_id==1){
            $athleteId= $this->athlete->id;
        }
        else if(auth()->user()->role_id==5){

            $athleteId= $this->athlete->id;
        }
        else{

            $athleteId= auth()->user()->athlete->id;
        }
        if($this->reason==null){
            $this->reason="Perpindahan Klub";
        }
        $date_request=date('Y-m-d');
        $migration=AthleteMigrationClub::create([
            'athlete_id'=> $athleteId,
            'new_club'=>$this->new_club_id,
            'old_club'=>$this->requestClub->club_id,
           'approver_1'=>null,
           'approver_2'=>null,
           'date_approve_1'=>null,
           'date_approve_2'=>null,
           'date_request'=>$date_request,
           'reason'=>$this->reason,
           'status'=>1
        ]);
        session()->flash('message', 'Profile photo updated successfully.');
        if(auth()->user()->role_id==1){
         $migration->update([
                'approver_2'=>auth()->user()->id,
                'date_approve_2'=>date('Y-m-d'),
                'status'=>0
            ]);
                athleteClub::where('athlete_id',$athleteId)->where('club_id',$migration->old_club)->first()->update(['status'=>0]);
                athleteClub::create(['athlete_id'=>$athleteId,'club_id'=>$migration->new_club,'status'=>1]);
            $message="Migrasi Disetujui";
        }
        if(auth()->user()->role_id==5){
         $migration->update([
                'approver_1'=>auth()->user()->id,
                'date_approve_1'=>date('Y-m-d'),
            ]);
            $message="Migrasi Disetujui";
        }
        Flux::modal('modal-club')->close();
    }
    public function selectOption($id,$name)
    {
        $this->new_club_id=$id;
        $this->new_club=$name;
        Flux::modal('modal-search')->close();
    }
    public function updatedKeyword()
    {
        $keyword=$this->keyword;
            $this->clubsByKeyword = $this->clubs->filter(function($club) use ($keyword) {
            return str_contains(strtolower($club->name), $keyword);
        });
    }
    public function migrationRequest($id)
    {
        $this->requestClub=$this->athlete->clubs->where('id',$id)->first();
        $this->clubDetail=$this->requestClub->club;
       $this->clubsByKeyword= $this->clubs= Club::where('id',"!=",$this->clubDetail->id)->where('id',"!=",1)->get();
        $this->modalChange(2);
        Flux::modal('modal-club')->show();
    }
    public function searchClub()
    {
        Flux::modal('modal-search')->show();
    }
    public $modalDetail=[];
    public function DetailClub($id)
    {
        $this->clubDetail= $this->athlete->clubs->where('club_id',$id)->first()->club;
        $this->modalChange(1);
        $this->modalDetail=[
                [
                "title"=>"Nama Club",
                "value"=>$this->clubDetail->name
                ]
                ,
                [
                "title"=>"Owner",
                "value"=>$this->clubDetail->owner
                ]
                ,
                [
                "title"=>"Alamat",
                "value"=>$this->clubDetail->address
                ]
        ];
        Flux::modal('modal-club')->show();

    }
    public function render()
    {
        if($this->role_id!=3){
            $email=$this->athlete->email;

        }else{
            $email=auth()->user()->email;
        }
        $athlete=Athlete::where("email",$email)->first();
        if($athlete==null){
            return $this->redirect('dashboard',navigate:true);
        }

        return view('livewire.athlete.athlete-profile', [
            'athlete' => $athlete,
            'parents'=>AthleteParent::where('athlete_id',$athlete->id)->get()
        ]);
    }
    public $name;
    public $email;
    public $phone;
    public $address;
    public $relation;
    public $gender;
    public $athlete_name;

    public function detailGuardian($id)
    {
        $guardian=AthleteParent::find($id);
        $this->name=$guardian->name;
        $this->email=$guardian->email;
        $this->phone=$guardian->phone;
        $this->address=$guardian->address;
        $this->relation=$guardian->relation;
        $this->gender=$guardian->gender;
        Flux::modal('detail-profile')->show();
    }
    public $photoPreview;
    public function updateUserProfile()
    {
        if($this->photoPreview){

            Storage::disk('public')->delete('athlete/' . $this->athlete->photo);
            $filename = md5($this->athlete->first_name) . '.' . $this->photoPreview->getClientOriginalExtension();
            $path = $this->photoPreview->storeAs('athlete', $filename, 'public');
            $this->athlete->update([
                'photo' => $filename,
            ]);
            session()->flash('message', 'Profile photo updated successfully.');
            $this->athlete->refresh();
            Flux::modal('edit-profile')->close();
            $this->photo=$this->photoPreview;
            if(auth()->user()->role_id==5){

                $idd=$this->athlete->id;
             return   $this->redirect("/athlete/$idd/profile",navigate:true);
            }

        }
    }
    public function updatedPhotoPreview()
    {
        Flux::modal('edit-profile')->show();

    }
    public function edit($id){
        $this->dispatch('editModal',$id);
    }
}
