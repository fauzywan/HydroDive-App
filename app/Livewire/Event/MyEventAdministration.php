<?php

namespace App\Livewire\Event;

use App\Models\Event;
use App\Models\EventAdministration;
use App\Models\EventAdministrationTransaction as Transaction;
use Flux\Flux;
use Livewire\Component;

class MyEventAdministration extends Component
{
    public $transactionNeeded;
    public function openModal($modal){
        Flux::modal($modal)->show();
    }
    public $id;
    public function mount()
    {
        if(auth()->user()->club == null){
            $this->id = 1;
        }else{

            $this->id = auth()->user()->club->id;
        }
    }
    public $typeButton = 1;
    public $idTransaction ;
    public $idAdministrtion;
    public function confirmPay($id,$adminId,$status){

        $this->typeButton=$status;
        $this->idTransaction = $id;
        $this->idAdministrtion= $adminId;
        Flux::modal('confirm-modal')->show();
    }
    public function confirmPayment()
    {
        if($this->typeButton==1){
               $status=1;
               $status_fee=0;
               $statustransaction=1;
               $message = "Pembayaran Disetujui";
            }else{
                $status=0;
                $status_fee=1;
                $statustransaction=0;
                $message = "Pembayaran   Ditolak";
            }
            Transaction::find($this->idTransaction)->update([
                'status'=>$status,
            ]);
            EventAdministration::find($this->idAdministrtion)->update(['status_fee'=>$status_fee,'status'=>$statustransaction]);

            session()->flash('message',$message);
            Flux::modal('confirm-modal')->close();
    }
      public function loadTransactions()
    {}
public function render()
{
    $eventIds = Event::where('club_id', $this->id)->pluck('id');
    $adminIds = EventAdministration::whereIn('event_id', $eventIds)->pluck('id');

    $allTransactions = Transaction::whereIn('administration_id', $adminIds)->get();

    $transactionsPending = $allTransactions->where('status', 2);
    $transactionsFinished = $allTransactions->whereIn('status', [0,1]); // ditolak atau diterima

    // filter aktif
    $transactions = match ($this->filter) {
        'all'     => $allTransactions,
        'finish'  => $transactionsFinished,
        'pending' => $transactionsPending,
        default   => $transactionsPending,
    };

    return view('livewire.event.my-event-administration', [
        'transactions'       => $transactions,
        'transactionsFinished' => $transactionsFinished,
        'transactionsPending'=> $transactionsPending,
        'allTransactions'    => $allTransactions
    ]);
}
public $filter = 'pending';
public function setFilter($type)
{
    $this->filter = $type;
}
    public $qrPhoto;
    public function closeModal($modal)
    {
        $this->qrPhoto = "";
        Flux::modal($modal)->close();
    }
    public function history($proof)
    {
        $this->qrPhoto = asset("storage/club/payment/")."/".$proof;

        Flux::modal('modal-detail')->show();
    }
    public $selectedGroupTransactions = [];

public function showGroupDetails($groupToken)
{
    $this->selectedGroupTransactions = Transaction::where('group_token', $groupToken)->get();
    Flux::modal('modal-group-detail')->show(); // Use JS to show modal
}


public function confirmGroupPay($groupToken, $status)
{
    $transactions = Transaction::where('group_token', $groupToken)->get();

    foreach ($transactions as $transaction) {
        $transaction->update(['status' => $status]);

        if($status==1){
            $transaction->administration->update(['status'=>1,'status_fee'=>0]);
        }else{
            $transaction->administration->update(['status'=>0,'status_fee'=>1]);
        }
    }

    session()->flash('message', 'Transaksi berhasil diperbarui.');
}
}
