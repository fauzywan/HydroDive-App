<?php

namespace App\Livewire\Event;

use App\Models\Athlete;
use App\Models\Club;
use App\Models\EventAdministration;
use App\Models\EventBranch;
use App\Models\EventMatch;
use App\Models\EventMatchPlayer;
use App\Models\PlayerTime;
use Flux\Flux;
use Illuminate\Http\Request;
use Livewire\Component;

class MatchTimeIndex extends Component
{
    public $athlete;
    public $branch_id=1;
    public $administration_id=1;
    public $athlete_id;
    public $athlete_name;
    public $event;
    public $keyword;
    public $selectedEventName;
    public $club;
    public $match_id=0;
    public $events=[];
    public $result;
    public $matches=[];
    public $allAthlete=null;
    public $athleteSearch=[];
    public $formType=1;
    public function mount($athlete="",$branch="")
    {

        if(auth()->user()->club){

            $this->club=auth()->user()->club;
        }
        if($athlete!="" && $branch!="")
        {   $this->athlete_name=Athlete::find($athlete)->name();
            if($this->administration_id)
            $this->administration_id=EventAdministration::where('athlete_id',$athlete)->where('event_branch_id',$branch)->where('status',1)->first();

            if($this->administration_id==null){
                      session()->flash('message','Data Atlet Tidak Tersedia');
                      return $this->redirect('/stopwatch',navigate:true);
              }
                       if(auth()->user()->role_id==1){
                $this->club=Club::find($this->administration_id->club_id);
               }
              $this->administration_id=$this->administration_id->id;
            $this->branch_id=$branch;
            $branch=EventBranch::find($this->branch_id);
            $this->selectedEventName=$branch->eventNumber->event->name;
            $this->selectedEventName.="(";
            $this->selectedEventName.=$branch->eventNumber->category->description;
            $this->selectedEventName.=")";
            $this->formType=2;
            if($branch->heats->where('status',1)->count()>0)
            {
                $het=$branch->heats->where('status',1)->first();

                if($het->players->where('athlete_id',$athlete)->count()>0){
                        session()->flash('message','Data Atlet Sudah Tersimpan');
                        return $this->redirect('/stopwatch',navigate:true);
                }
            }
          $this->matches = $het->matches->where('status', 1);
          $this->match_id = $this->matches->first()?->id;
        }
    }
    public function storeTime()
    {

            if($this->match_id != 0){
                    $match=$this->match_id;
            }else{
        $branch=(EventBranch::find($this->branch_id));

                 $heat=$branch->heats->where('status',1)->first();
        $heatID=$heat->id;
        if(EventMatch::where('heat_id',$heatID)->count()==0)
            {
                EventMatch::create(['heat_id'=>$heatID,'name'=>$heat->name,'heat'=>EventMatch::where('heat_id',$heatID)->count()+1,
                'start_time'=>date('Y-m-d H:i:s'),'end_time'=>date('Y-m-d H:i:s'),'status'=>1]);
            }
                $match=EventMatch::where('heat_id',$heatID)->first()->id;

            }
            if(EventMatchPlayer::where('event_match_id',$match)->
                where('administration_id',$this->administration_id)->count()>0){
                     $player=EventMatchPlayer::where('event_match_id',$match)->
                where('administration_id',$this->administration_id)->first();
                 $status=   $player->update([
                        'start_time'=>"00:00:00",
                        'end_time'=>$this->end_time,
                        'result_time'=>$this->end_time,
                    ]);

                }else{
                    $categoryId= EventMatch::find($match->id)->Heat->branch->eventNumber->category_id;
                    $player= EventMatchPlayer::create([
                        'event_match_id'=>$match,
                        'category_id'=>$categoryId,
                        'administration_id'=>$this->administration_id,
                        'club_id'=>$this->club->id,
                        'start_time'=>"00:00:00",
                        'end_time'=>$this->end_time,
                        'result_time'=>$this->end_time,
                        'status'=>1,
                        'rank'=>1,
                        'line'=>$this->line,
                'athlete_id'=>EventAdministration::find($this->administration_id)->athlete_id,
            ]);
        }

            if ($player) {
        PlayerTime::create([
            'player_id' => $player->id,
            'start_time' => now(),
            'finish_time' => now(),
            'duration' => $this->end_time,
        ]);
    }
                 session()->flash('message','Data Atlet Sudah Tersimpan');
                        return $this->redirect('/stopwatch',navigate:true);
             Flux::modal('search-athlete')->close();
    }
    public function render()
    {
        return view('livewire.event.match-time-index');
    }

   public function updatedKeyword()
{
    $this->searchKeyword();
    }
   public function searchKeyword()
{
    if ($this->allAthlete === null) {
        $this->allAthlete = Athlete::all(); // Pastikan pakai relasi yg benar
    }

    $this->athleteSearch = collect($this->allAthlete)->filter(function ($athlete) {
        $fullName = strtolower($athlete->first_name . ' ' . $athlete->last_name);
        return str_contains($fullName, strtolower($this->keyword));
    })->values();

}
    public function startStopwatch()
    {
        $branch=EventBranch::find($this->branch_id);
               $this->selectedEventName=$branch->eventNumber->event->name;
                $this->selectedEventName.="(";
                $this->selectedEventName.=$branch->eventNumber->category->description;
                $this->selectedEventName.=")";
        $this->formType=2;
        return $this->redirect("/stopwatch/$this->athlete_id/$this->branch_id/show-menu",navigate:true);
        }
    public function searchName()
        {
            if($this->allAthlete==null)
            {
                $this->allAthlete=Athlete::all();
            }
            $this->athleteSearch=$this->allAthlete;
            Flux::modal('search-athlete')->show();
        }
        public $line;
        public $end_time;
      public function FinishStopWatch($finalTimeMs, $lapTimes)
    {

    $totalSeconds = floor($finalTimeMs / 1000);
    $remainingMilliseconds = $finalTimeMs % 1000;
    $hundredthsOfSecond = floor($remainingMilliseconds / 10);

    $minutes = floor($totalSeconds / 60);
    $seconds = $totalSeconds % 60;

    $formattedTime = sprintf('%02d:%02d:%02d', $minutes, $seconds, $hundredthsOfSecond);
    $this->end_time=$formattedTime;

    Flux::modal('finish-modal')->show();

    }
        public function selectOption($id,$name)
        {
            $this->athlete_id=$id;
            $this->athlete_name=$name;
            $this->events=EventAdministration::where('athlete_id',$id)->where('status',1)->get();
            if($this->events->count()>0){
                    $this->branch_id=$this->events->first()->event_branch_id;
            }



         Flux::modal('search-athlete')->close();
        }


}
