<?php

namespace App\Livewire\Club;

use App\Models\athleteClub;
use App\Models\AthleteMigrationClub;
use Flux\Flux;
use Livewire\Component;

class MigrationAthlete extends Component
{

    public $typeButton="danger";
    public $migrationSelected;
    public $navigations;
    public $navActive=1;
    public $modalType=1;
    public function show($no)
    {
        $this->navActive=$no;
    }
    public function mount()
    {
          $this->navigations = [
            ["no" => 1, "name" => "List"],
            ["no" => 2, "name" => "Riwayat"],
        ];
    }
    public function confirmMigration($id,$type)
    {
        $this->migrationSelected=AthleteMigrationClub::find($id);
        $this->typeButton=$type;
            $this->modalType=$type;

        Flux::modal('confirm-modal')->show();

    }
    public function Migration()
    {
        if(auth()->user()->role_id==1)
        {
            if($this->modalType==1){

                $this->migrationSelected->update([
                'approver_2'=>auth()->user()->id,
                'date_approve_2'=>date('Y-m-d'),
                'status'=>0
            ]);
                athleteClub::where('athlete_id',$this->migrationSelected->athlete_id)->where('club_id',$this->migrationSelected->old_club)->first()->update(['status'=>0]);
                athleteClub::create(['athlete_id'=>$this->migrationSelected->athlete_id,'club_id'=>$this->migrationSelected->new_club,'status'=>1]);
            $message="Migrasi Disetujui";
        }else{
            $this->migrationSelected->update([
                'status'=>0
            ]);
            $message="Migrasi Berhasil Ditolak";
        }
        }else{

            if($this->modalType==1){

                $this->migrationSelected->update([
                'approver_1'=>auth()->user()->id,
                'date_approve_1'=>date('Y-m-d'),
                'status'=>2
            ]);
            $message="Migrasi Disetujui";
        }else{
            $this->migrationSelected->update([
                'status'=>0
            ]);
            $message="Migrasi Berhasil Ditolak";
        }
    }
        session()->flash('message',$message);
        Flux::modal('confirm-modal')->close();

    }
    public function render()
    {
        $status=0;
        if($this->navActive==1){
            $status=1;
            if(auth()->user()->role_id==1){
                $status=2;
            }
            $migrations=AthleteMigrationClub::where('status',$status)->get();

        }else if($this->navActive==2){
        $migrations=AthleteMigrationClub::where('status',$status)->get();
        }
        return view('livewire.club.migration-athlete',['migrations'=>$migrations]);
    }
}
