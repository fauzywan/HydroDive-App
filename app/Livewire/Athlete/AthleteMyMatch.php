<?php

namespace App\Livewire\Athlete;

use App\Models\Athlete;
use App\Models\EventAdministration;
use Livewire\Component;

class AthleteMyMatch extends Component
{
    public $mathces;
    public $athlete ;
    public $navigations ;
    public $navActive=1 ;
    public $navActiveDesc="Daftar Perlombaan yang Sedang Berlangsung" ;
    public $eventYears=[] ;
    public function show($no)
    {
        $this->navActive=$no;
        $this->mathces=$this->loadMatch($no);
        $this->navActiveDesc=($this->navigations[$no-1]['desc']);

    }
    public function mount(){
        $this->navigations=[
                ["no"=>1,"name"=>"Berlangsung","desc"=>'Daftar Perlombaan yang Sedang Berlangsung'],
                ["no"=>2,"name"=>"Riwayat",'desc'=>'Daftar Perlombaan yang Telah Berakhir'],
        ];
        $this->athlete=Auth()->user()->athlete;
        $this->mathces=$this->loadMatch(1);


    }
    function loadMatch($type){
        if($type==1){
            $mathces=EventAdministration::where('athlete_id',$this->athlete->id)->where('status',1)->get();

        }elseif($type==2){

            $mathces=EventAdministration::where('athlete_id',$this->athlete->id)->where('status','!=',0)->get();
        }
        if($mathces){
            $mathces=$mathces->map(function($p){
                return ['event_name'=>$p->event->name,'match_name'=>$p->player->match->name,'rank'=>$p->rank,'time'=>$p->player->result_time,]
            ;});
        }
        return $mathces;
    }
    public function render()
    {

        return view('livewire.athlete.athlete-my-match');
    }
}
