<?php

namespace App\Livewire\Event;

use App\Models\Athlete;
use App\Models\athleteClub;
use App\Models\EventAdministration;
use App\Models\EventBranch;
use Carbon\Carbon;
use Flux\Flux;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Reference\Reference;
use Livewire\Component;

class EventPartisipan extends Component
{
    public $first_name;
    public $branch;
    public $athleteSearch;
    public $clubId;
    public $athleteCount;
    public $onlyGender="";
    public $searchAthlete;
    public $typeModalSearch;
    public $eventStatus;
    public $minMaxAge;
    public $event;
    public function mount($id)
    {
        $this->typeModalSearch=1;
        $this->branch=EventBranch::find($id);
        $this->clubId=auth()->user()->club->id;
       $isGender=$this->branch->eventNumber->category->gender;
        if($isGender=="MEN"){
            $this->onlyGender='male';
        }
        elseif($isGender=="WOMEN"){
            $this->onlyGender="female";
        }
        $this->minMaxAge=$this->branch->age;

        $this->event=$this->branch->eventNumber->event;

    }
    public function searchingAthlete()
    {
        if($this->typeModalSearch==1){
            $this->typeModalSearch=2;
        }
        $keyword=$this->searchAthlete;


        $athlete= $this->searchAthleteFirst();
        $this->athleteSearch=$athlete->filter(function($a){
            return !EventAdministration::where('athlete_id',$a->id)->where('event_branch_id',$this->branch->id)->count();
        });
    }
    public function searchAthleteFirst(){
        $keyword = $this->searchAthlete;
        $referenceYear = Carbon::createFromDate(now()->year, 1, 1)->year;
    $referenceYear= date("Y",strtotime($this->branch->eventNumber->event->competition_start));
    // Hitung tahun minimum dan maksimum berdasarkan usia

    $minYear = $referenceYear - $this->minMaxAge->min_age;
    $maxYear = $referenceYear - $this->minMaxAge->max_age;

$athleteQuery = athleteClub::where('status', 1)
    ->where('club_id', $this->clubId)
    ->whereHas('athlete', function ($query) use ($keyword, $minYear, $maxYear) {
        $query->where(function ($q) use ($keyword) {
            $q->where('first_name', 'LIKE', "%$keyword%")
              ->orWhere('last_name', 'LIKE', "%$keyword%");
        });

        $query->whereYear('dob', '<=', $minYear)
              ->whereYear('dob', '>=', $maxYear);
    });

if (!empty($this->onlyGender)) {
    $athleteQuery->whereHas('athlete', function ($query) {
        $query->where('gender', $this->onlyGender);
    });
}

// Ambil hasil dan mapping ke relasi athlete
$athletes = $athleteQuery->get()->map(function ($a) {
    return $a->athlete;
});
        return $athletes;
    }
        public function recruitAthlete($id)
        {

            if(EventAdministration::where('club_id',auth()->user()->club->id)
                ->where('event_branch_id',$this->branch->id)
                ->where('created_at','>=',$this->event->competition_start)
            ->count()>=$this->branch->capacity_per_club){
                session()->flash('message','Gagal Menambahkan atlet,kapasitas maksimal sudah tercapai');
                Flux::modal('search-athlete')->close();
                return ;
            }
            EventAdministration::create([
                'event_id'=>$this->event->id,
                'event_branch_id'=>$this->branch->id,
                'club_id' =>$this->clubId,
                'athlete_id'=>$id,
                'rank'=>0,
                'fee'=>$this->branch->registration_fee,
                'status_fee'=>1,
                'status'=>0
             ]);
             session()->flash('message','Berhasil Menambahkan atlet,Selesaikan administrasi Anda');
             Flux::modal('search-athlete')->close();
        }
        public function modalAthlete()
        {
            $this->typeModalSearch=1;
            $minAge=$this->branch->min_age;
            $maxAge=$this->branch->max_age;
          $this->athleteSearch= $athlete=$this->searchAthleteFirst();
        $this->athleteSearch=$athlete->filter(function($a){
            return !EventAdministration::where('athlete_id',$a->id)->where('event_branch_id',$this->branch->id)->count();
        });
            Flux::modal('search-athlete')->show();
        }
    public function render()
    {


        $partisipan=EventAdministration::where('event_branch_id',$this->branch->id)->where('club_id',$this->clubId)->get();
        return view('livewire.event.event-partisipan',
        ['partisipan'=>$partisipan]
    );
}
public $participatedEvents = [];
public $athletes = [];
public $selectedAthleteId, $eventIdBeingRegistered;



public function openAddAthleteModal($eventId)
{
    $this->eventIdBeingRegistered = $eventId;
    $this->selectedAthleteId = null;
    $this->dispatchBrowserEvent('open-modal', ['name' => 'add-athlete-modal']);
}

public function registerAthlete()
{
    $this->validate([
        'selectedAthleteId' => 'required|exists:athletes,id',
    ]);

    EventAdministration::create([
    ]);

    session()->flash('message', 'Atlet berhasil didaftarkan!');
    $this->dispatchBrowserEvent('close-modal', ['name' => 'add-athlete-modal']);
    $this->mount(); // Refresh data
}

}
