<?php

namespace App\Livewire\Event;

use App\Models\Event;
use App\Models\EventAdministration;
use App\Models\EventAdministrationTransaction as Transaction;
use App\Models\EventClub;
use App\Models\EventDate;
use App\Models\EventMatch;
use App\Models\EventMatchPlayer;
use Flux\Flux;
use Livewire\Component;

class EventHistoryDetail extends Component
{
    public $dateSelect;
    public $dateStart;
    public $qrPhoto;
    public $dateEnd;
    public $eventDates;
    public $proof;
    public $event;
    public $navActive=1;
    public function history($proof)
    {
        $this->qrPhoto = asset("storage/club/payment/")."/".$proof;

        Flux::modal('modal-detail')->show();
    }
    public $Matches;
    public function mount($year,$id)
    {


        $this->navigations=[
            ["no"=>1,"name"=>"Home"],
                ["no"=>2,"name"=>"Peserta"],
                ["no"=>3,"name"=>"Club"],
                ["no"=>4,"name"=>"Transaksi Pendaftaran"],
                ["no"=>5,"name"=>"Pertandingan"],
            ];
            $this->event=Event::find($id);
           $dates = $this->event->dates
            ->filter(function ($item) use ($year) {
                return \Carbon\Carbon::parse($item->competition_start)->year == $year;
            })
            ->unique('competition_start');
            $this->eventDates = $dates;
            $this->dateSelect = $this->eventDates->first()->id;
            $this->dateStart = $this->eventDates->first()->competition_start;
            $this->dateEnd = $this->eventDates->first()->competition_end;


}
       public function updatedDateSelect()
    {
            $selected = $this->eventDates->find($this->dateSelect);
            $this->dateStart = $selected->competition_start;
            $this->dateEnd = $selected->competition_end;


    }
       public function show($no)
    {
         $this->navActive=$no;

    }
    public $clubs=[];
    public $players=[];
    public $branches=[];
    public $transactions=[];

    public function render()
    {
        $start=date('Y-m-d',strtotime($this->dateStart));
            $end=date('Y-m-d',strtotime($this->dateEnd));
        $players = EventMatchPlayer::with('match')
                           ->whereDate('created_at', '>=', $start)
                           ->whereDate('created_at', '<=', $end) // <-- Ganti di sini
                           ->get();
$this->Matches = $players->pluck('match')->unique('id');

    $this->clubs = EventClub::where('event_id', $this->event->id)
        ->whereBetween('created_at', [$this->dateStart, $this->dateEnd])
        ->get();

        $this->players= $players=$this->event->administration->whereBetween('created_at', [$this->dateStart, $this->dateEnd]);
         $this->transactions = $players->map(function ($admin) {
            return $admin->transaction;
            })->flatten();
        return view('livewire.event.event-history-detail');
    }

       public $navigations=0;
    public $selectedGroupTransactions = [];

public function showGroupDetails($groupToken)
{
    $this->selectedGroupTransactions = Transaction::where('group_token', $groupToken)->get();
    Flux::modal('modal-group-detail')->show(); // Use JS to show modal
}


}
