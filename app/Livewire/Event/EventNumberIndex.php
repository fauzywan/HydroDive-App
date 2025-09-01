<?php

namespace App\Livewire\Event;

use App\Models\EventAdministration;
use App\Models\EventBranch;
use App\Models\EventHeat;
use App\Models\EventMatch;
use App\Models\EventNumber;
use Flux\Flux;
use Livewire\Component;

class EventNumberIndex extends Component
{
    public $eventNumber;
    public $matches=[];
    public $navigations;

    public $selectedHeat=[];
    public $navActive;
    public $eventBerlangsung;
    public function mount($id)
    {
        $this->eventBerlangsung=EventHeat::where('status',1)->first();
        if($this->eventBerlangsung){
            if($this->eventBerlangsung->matches->where('status',1)->count()==0){
            $this->matchStatus=0;
        }
    }

        $this->selectedHeat=EventHeat::where('status',1)->first();

        $this->sessions=[['name'=>'Penyisihan','id'=>1],['id'=>2,'name'=>'FINAL']];

        $this->navigations=[
            ["no"=>1,"name"=>"Daftar","href"=>'list'],
            ["no"=>2,"name"=>"Sesi","href"=>'list-heat'],
            ["no"=>3,"name"=>"Match","href"=>'match'],
        ];
        $this->eventNumber=EventNumber::find($id);
          if(auth()->user()->role_id==5){
            if($this->eventNumber->event->club_id!=auth()->user()->club->id){
                    return $this->redirect('/club/my-event',navigate:true);
            }
        }
         if(request()->segment(3)=="list-heat")
        {
            $this->navActive=2;
        }
        elseif(request()->segment(3)=="match")
        {
            $this->navActive=3;
    $this->matches = $this->eventNumber->branches
        ->flatMap(function ($branch) {
            return $branch->heats->where('status',1)->flatMap(function ($heat) {
                return $heat->matches;
            });
        });

        }
        else{
            $this->navActive=1;

        }
    }
    public function pauseHeat($id,$isFinal)
    {
               session()->flash('message', 'Event Dijeda');

        EventHeat::find($id)->update(['status'=>2]);
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
    public $heates=[];
    public $heates_id;
    public function StartEventByBranch($id,$capacity)
    {

        $this->heates=EventHeat::where('branch_id',$id)->get();
        if($this->heates!=null){
            $this->heates_id=$this->heates[0]->id;
        }
        Flux::modal("select-event")->show();

        // $this->StartEvent($id,$capacity,1);
    }
    public function startEventHeatById(){
         $this->StartEvent($this->heates_id,0,1);


    }
    public function EndtEvent($id,$capacity,$status=0)
    {
        return $this->redirect("/heat/$id/finish");
        // if(EventHeat::where('branch_id',$heat->branch_id)->where('round',$heat->round+1)->count()){
        //     EventHeat::where('branch_id',$heat->branch_id)->where('round',$heat->round+1)->first()->update(['status'=>1]);
        // }
        // $heat->update(['status'=>-1]);
    }
    // public $selectActiveBack;
    //  public function activeBackHeat()
    // {
    //     $t
    // }
    public function StartEventBack($id,$capacity,$status=0)
    {

          if($this->selectedHeat->event->status==1){



        $this->selectedHeat=EventHeat::find($id);
        if(EventHeat::where('status',1)->count()>0){
            session()->flash('message', 'Event Masih Berlangsung Hentikan / Selesaikan Terlebih Dahulu');
        } else {

            // if(EventHeat::find($id)->matches->count()==0){
                session()->flash('message', 'Event Diaktifkan');
                EventHeat::find($id)->update(['status'=>1]);

        // }else{
        //     $this->selectActiveBack=EventHeat::find($id)->matches->where('status',2)->first()->id;
        //     Flux::modal('session-continue')->show();
        // }

        }
         }else{
            session()->flash('message', 'Kompetisi Belum Dimulai/ Selesai');


        }
    }
    public function createMatch($id)
    {
          return $this->redirect("/event/$id/select-player",navigate:true);

    }
    public function StartEvent($id,$capacity,$status=0)
    {
             if(EventHeat::where('status',1)->count()>0 || $this->eventNumber->event->status!=1){
            if( $this->eventNumber->event->status!=1){
                session()->flash('message', 'Kompetisi Belum Dimulai/ Selesai');
            }else{

                session()->flash('message', 'Event Masih Berlangsung Hentikan / Selesaikan Terlebih Dahulu');
            }
    } else {
        return $this->redirect("/event/$id/select-player",navigate:true);
    }

        // if($status==1){

        //     $heat= EventHeat::where('branch_id',$id)->where('status',0)->first();
        // }else{

        //     $heat= EventHeat::find($id);
        // }


        // for ($i=0; $i < $heat->heat_total; $i++) {
        //     EventMatch::create([
        //         'heat_id'=>$heat->id,
        //         'name'=>$heat->name."-".$heat->branch->name." ".$heat->branch->age->showName()."- Heat ".($i+1),
        //         'heat'=>($i+1),
        //         'start_time'=>now(),
        //         'end_time'=>now(),
        //         'status'=>1,
        //     ]);
        // }

        // $heat->update(['status'=>1]);
        //     session()->flash('message','Berhasil Mengaktifkan Event');
        }
        public function show($no)
    {
        $this->navActive=$no;
    }
public function toggleStatus($branchId)
{
    $branch = EventBranch::findOrFail($branchId);
    $branch->status = !$branch->status;
    $branch->save();
    if ($branch->status) {
        session()->flash('message', 'Kegiatan Berhasil Diaktifkan.');
    } else {
        session()->flash('message', 'Kegiatan Berhasil Dinonaktifkan.');
    }
}

    public $first_name;
    public $branchSelected;
    public $total_heat;
    public $from_rank=0;
    public $to_rank=0;
    public $total_line;
    public $capacity;
    public $groupSelectedName;
    public $name_heat;
    public $roundSelect=0;
    public $sessions=[];
    public $best_of;

    public function addHeat()
    {
        $rules=[
            'name_heat'=>'required',
            'capacity'=>'required',
            'best_of'=>'required',
        ];
        $this->validate($rules);
        $eventId=$this->branchSelected->eventNumber->event_id;

        $status=0;
       EventAdministration::where('rank',">",$this->best_of)->where('event_branch_id',$this->branchSelected->id)->update(['status'=>0]);
       EventHeat::create([
            'event_id'=>$eventId,
            'branch_id'=>$this->branchSelected->id,
            'name'=>$this->name_heat,
            'capacity'=>$this->total_line,
            'heat_total'=>$this->total_heat,
            'best_of'=>$this->best_of,
            'from_rank'=>1,
            'to_rank'=>8,
            'is_final'=>0,
            'is_sp'=>0,
            'round'=>($this->branchSelected->heats->count()+1),
            'status'=>$status,
        ]);
        Flux::modal('session-branch')->close();
        session()->flash('message','Berhasil');
    }
    public function prelimSet($id)
    {
        $this->branchSelected=EventBranch::find($id);
         $this->roundSelect=$this->branchSelected->heats->count();
         $this->best_of=$this->branchSelected->line;
         $this->name_heat="FINAL";
        $capacity=$this->branchSelected->capacity;
        if($this->branchSelected->heats->count()>0){
            $latestHeat = $this->branchSelected->heats()->latest()->first();
            $capacity=$latestHeat->best_of;
            if($capacity==$this->branchSelected->line)
            {
                $this->name_heat="FINAL";
                $this->best_of=0;
            }
        }
        $this->total_heat=floor($capacity/$this->branchSelected->line);
        $this->total_line=$this->branchSelected->line;
        $this->capacity=$capacity;
        $this->groupSelectedName=$this->branchSelected->age->name;
        if($this->branchSelected->is_final==1){
            $this->best_of=0;
            $this->name_heat="FINAL";

        }
        Flux::modal('session-branch')->show();

    }
    public function detailMatch($id)
    {
  return $this->redirect("/match/$id/play");
    }
    public function goToEventBerlangsung($id)
    {
      // Cari match yang aktif berdasarkan heat_id
$match = EventMatch::where('heat_id', $id)->where('status', 1)->first();

if ($match) {
    $this->detailMatch($match->id);
} else {
    $this->createMatch($id);
}

    }
    public function GoToActiveEvent($id)
    {
        // $id=EventMatch::where('heat_id',$id)->where('status',1)->first()->id;
        // $this->detailMatch($id);
        $match = EventMatch::where('heat_id', $id)->where('status', 1)->first();

if ($match) {
    $this->detailMatch($match->id);
} else {
    $this->createMatch($id);
}

    }
    public $matchStatus=1;
    public function render()
    {
        return view('livewire.event.event-number-index');
    }

}
