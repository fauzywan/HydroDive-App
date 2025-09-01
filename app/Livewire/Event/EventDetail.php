<?php

namespace App\Livewire\Event;

use App\Models\Category;
use App\Models\EventDate;
use App\Models\EventHeat;
use App\Models\EventMatch;
use App\Models\EventNumber;
use Carbon\Carbon;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class EventDetail extends Component
{
    use WithPagination;
    public $event;
    public $keyword = '';
    public $first_name;
    public $navigations;
    public $navActive;

    public $formShow=1;

#[On('eventRegistered')]
public function refreshEvent($eventId)
{
    $this->event = \App\Models\Event::with('branches')->findOrFail($eventId);
}

    public function show($no){
        $this->formShow=$this->navActive=$no;
    }
    public function mount($id){

        $this->competition_date=date('Y-m-d H:i');
        $this->navActive=1;
        $this->event = \App\Models\Event::with('branches')->findOrFail($id);
         $this->competition_date=date('Y-m-d H:i:s') ;
            if(auth()->user()->role_id==5){
            if($this->event->club_id!=auth()->user()->club->id){
                    return $this->redirect('/club/my-event',navigate:true);
            }
        }

$this->navigations=[
            ["no"=>1,"name"=>"Nomor Acara"],
            ["no"=>3,"name"=>"Athlete"],
            ["no"=>4,"name"=>"Perlombaan"],
            ["no"=>6,"name"=>"Club"],
            ["no"=>7,"name"=>"Poster"],
            ["no"=>5,"name"=>"On / Off"],
        ];
    }
    public bool $showConfirmOnOff = false;
    public $competition_date;
   public $matchStatus=1;

public function onOrOff($type)
{
    if ($type == 1) {

        if ($this->event->registered->where('status', 1)->count() > 0) {
            $this->event->registered->where('status', 1)->map(function ($a) {
                $a->update(['status' => 0]);
            });
        }
        if ($this->event->administration->where('status', 1)->count() > 0) {
            $this->event->administration->where('status', 1)->map(function ($a) {
                $a->update(['status' => -1]);
            });
        }
        if ($this->event->sessions->where('status', 1)->count() > 0) {
            $this->event->sessions->where('status', 1)->map(function ($a) {
                $a->update(['status' => -1,'round'=>0]);
            });
        }

        EventDate::where('event_id', $this->event->id)->first()->update([
            'status' => 0,
            'competition_end' => $this->competition_date,
        ]);

        $this->event->update([
            'competition_end' => $this->competition_date,
        ]);

        session()->flash('message', "Event Dinonaktifkan");
    } else {
        if (EventHeat::where(['event_id' => $this->event->id])->count()) {
        EventHeat::where(['event_id' => $this->event->id])->update(['round'=>0,'status'=>0]);
        }
        if (EventHeat::where(['round' => 1, 'event_id' => $this->event->id])->count()) {
            if (EventHeat::where('round', '!=', 1)->where('event_id', $this->event->id)->count()) {
                EventHeat::where('round', '!=', 1)->where('event_id', $this->event->id)->update(['status' => -1]);
            }
        }

        $endDate = Carbon::parse($this->competition_date)->addDay();

        $this->event->update([
            'competition_start' => $this->competition_date,
            'competition_end'   => $endDate,
        ]);

        EventDate::create([
            'event_id'          => $this->event->id,
            'competition_start' => $this->competition_date,
            'competition_end'   => $endDate,
            'status'            => 1,
        ]);

        session()->flash('message', "Event Diaktifkan");
    }

    $this->event->update(['status' => !$type]);
    Flux::modal('confirm-onoff')->close();
}
    public function updatingKeyword(){
      $this->gotoPage(1);
    }
    public $idUpdateClub;
    public $updateStatus;
    public function updateClub(){

           $club  = \App\Models\EventClub::find($this->idUpdateClub);
        $club->update(['status'=>$this->updateStatus]);
        if($this->updateStatus==1){
        session()->flash('message','Berhasil Menghapus Club');
        }
        else{

            session()->flash('message','Berhasil Menghapus Club');
        }
          Flux::modal('modalClub')->close();
    }
    public function acceptClub($id){
        $this->idUpdateClub=$id;
        $this->updateStatus=1;
        Flux::modal('modalClub')->show();

    }
    public function deleteClub($id){
        $this->idUpdateClub=$id;
        $this->updateStatus=-1;
         Flux::modal('modalClub')->show();


    }
    public function confimONFF(){
        Flux::modal('confirm-onoff')->show();
    }
    public function render(){

    $event_numbers = $this->event->numbers;
    $this->number=$this->event->numbers->first();
    if($this->event->numbers->count()>0){
        $this->number = $this->event->numbers->sortByDesc('number')->first();
        $this->number=$this->number->number+1;
    }
    return view('livewire.event.event-detail',
    [
        'event_numbers' => $event_numbers,
        'eventBerlangsung'=>EventHeat::where('status',1)->first(),
    ]);
    }
    public function GoToActiveEvent($id)
    {

        $id=EventMatch::where('heat_id',$id)->where('status',1)->first()->id;
        return $this->redirect("/match/$id/play");
    }
   public function delete($id)
   {
         $branch = \App\Models\EventBranch::find($id);
         $this->first_name=$branch->name;
         Flux::modal('delete-branch')->show();
   }
    public function badgeStatus($status)
    {
        if ($status == 1) {
            return '<small class="inline-block px-3 py-1  font-medium text-white bg-blue-500 rounded-full mb-2">Belum Dimulai</small>';
        } elseif ($status == 2) {
            return '<small class="inline-block px-3 py-1  font-medium text-white bg-green-500 rounded-full mb-2">Sedang Berlangsung</small>';
        } elseif ($status == 0) {
            return '<small class="inline-block px-3 py-1  font-medium text-white bg-red-500 rounded-full mb-2"> Selesai</small>';
        }
    }


    public $keyword_category;
    public $categorySearch;
        public function updatedKeywordCategory()
    {
        $this->categorySearch = Category::where('description', 'LIKE', "%".strtoupper($this->keyword_category) . '%')
        ->get();
    }
        public function searchKeywordCategory()
    {
        $this->categorySearch = Category::where('description', 'LIKE', "%".strtoupper($this->keyword_category) . '%')
        ->get();
    }
      public function searchKeyword()
    {
        $this->categorySearch = Category::where('description', 'LIKE', "%".strtoupper($this->keyword) . '%')
        ->get();
    }

        public $name_category;
        public $category_id;
        public $isRelay;
        public function selectOption($id,$name,$relay){
        $this->name_category=$name;

        $this->category_id=$id;
        $this->isRelay=$relay;
        Flux::modal('search-category')->close();
    }
      public function searchCategory()
    {
         if(!$this->categorySearch){
           $this->categorySearch = Category::get(['id','description','relay']);
         }
        Flux::modal('search-category')->show();
    }
    public $formType="save";
    public function clearForm($no=0)
    {
          $this->name_category=$no;
         $this->category_id="";
         $this->isRelay="";

    }
    public function save()
    {
        $rules=[
            'number'=>'required',
            'category_id'=>'required'
            ];
        $this->validate($rules);

       $create= EventNumber::create([
            'number'=>$this->number,
            'event_id'=>$this->event->id,
            'category_id'=>$this->category_id,
            'is_relay'=>$this->isRelay,
        ]);
        session()->flash('message','Berhasil Menambahkan Nomor Perlombaan');
        $this->clearForm($this->number);
        Flux::modal('modal-number')->close();

    }
    public function addNomor()
    {
        $this->formType='save';

        Flux::modal('modal-number')->show();
    }
    public $number=101;
   public function goToEventBerlangsung($id)
    {
        $id=EventMatch::where('heat_id',$id)->where('status',1)->first()->id;
        $this->detailMatch($id);

    }
    public function pauseHeat($id,$isFinal)
    {
               session()->flash('message', 'Event Dijeda');

        EventHeat::find($id)->update(['status'=>2]);
    }
     public function EndtEvent($id,$capacity,$status=0)
    {
        return $this->redirect("/heat/$id/finish");
    }
        public function detailHeat($id,$isFinal)
    {
        if($isFinal==1){

            return $this->redirect("/match/$id/player",navigate:true);
        }else{

             return $this->redirect("/match/$id/list",navigate:true);
        }
        $heat=EventHeat::find($id);
    }

      public function detailMatch($id)
    {
    return $this->redirect("/match/$id/play");
    }
}
