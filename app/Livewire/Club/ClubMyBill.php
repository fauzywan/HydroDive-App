<?php

namespace App\Livewire\Club;

use App\Models\ClubRegistrationFee;
use App\Models\ClubRegistrationTransaction;
use App\Models\PaymentGateway;
use App\Models\PaymentGatewayToken;
use Carbon\Carbon;
use App\Models\ClubWaitingList;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Midtrans\Config;
use Midtrans\Snap;

class ClubMyBill extends Component
{
    public $club;
    public $clientKey;
    public $snapPay;
    public $isLoading=false;
    protected $listeners = ['paymentSuccess', 'paymentPending', 'paymentError'];
    
    public function paymentPending($result)
    {
        $this->isLoading=true;
        if($this->pgt){
            $pgt = PaymentGatewayToken::find($this->pgt);
            $pgt->update([
                'order_id'=>$result['order_id'],
                'status' => 2,
            ]);
        }
        $this->isLoading=false;
        session()->flash('success', 'Pembayaran Tertunda.');

    }
    public function paymentSuccess($result)
    {
        $this->isLoading=true;
        if($this->pgt){
            $pgt = PaymentGatewayToken::find($this->pgt);
            $pgt->update([
                'order_id'=>$result['order_id'],
                'status' => 0,
            ]);
            $feeId=clubRegistrationFee::where('club_id', $this->club->id)->first();
             ClubRegistrationTransaction::create([
            'club_registration_fee_id' =>$feeId->id,
            'amount' => $result['gross_amount'],
            'pay_time' => Carbon::now(),
            'desc' => $result['order_id'],
        ]);
        $feeId->update([
            'remaining_fee' => $feeId->remaining_fee - $result['gross_amount'],
        ]);
        if($feeId->remaining_fee==0){
            $feeId->update(['status'=>0]);
            ClubWaitingList::create(['club_id'=>$this->club->id,"status"=>1,"message"=>"","Approver"=>""]);        
          }
        $this->isLoading=false;
        session()->flash('success', 'Pembayaran berhasil.');

        // $this->pgt->update(['orderId'=>$result['order_id']]);

    }
}
    public function mount()
    {
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
        $this->club = auth()->user()->club;
    }
    public $paymentStatus;
    public function cekStatus($orderId)
    {
        $pg = PaymentGateway::first();
        $serverKey = $pg->server_key;
        $base64ServerKey = base64_encode($serverKey . ':');

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $base64ServerKey,
        ])->get("https://api.midtrans.com/v2/{$orderId}/status");

        if ($response->successful()) {
            $data = $response->json();
            $this->paymentStatus = "Status pembayaran untuk order {$orderId}: " . $data['transaction_status'];
            
        } else {
            $this->paymentStatus = "Gagal mendapatkan status pembayaran.";
        }
        dd($this->paymentStatus);
    }

    public function cekBill($bill)
    {

        if(!PaymentGatewayToken::where('club_id',$this->club->id)->count()){
            $this->payBill($bill);
        }else{
            $this->pgt= PaymentGatewayToken::where('club_id',$this->club->id)->first();
             $pg = PaymentGateway::first();
        $serverKey = $pg->server_key;
        $base64ServerKey = base64_encode($serverKey . ':');
        $orderId= $this->pgt->order_id;
        $response = Http::withHeaders([
        'Authorization' => 'Basic ' . $base64ServerKey,
    ])->get("https://api.sandbox.midtrans.com/v2/{$orderId}/status");

    if ($response->successful()) {
        $data = $response->json();

        // Contoh akses hasil
        $status = $data['transaction_status'];
        $paymentType = $data['payment_type'];
        $grossAmount = $data['gross_amount'];

        // Tampilkan atau simpan ke database
       if($status=="settlement"){
            $this->pgt->update([
                'status' => 0,
            ]);
            $feeId=clubRegistrationFee::where('club_id', $this->club->id)->first();
             ClubRegistrationTransaction::create([
            'club_registration_fee_id' =>$feeId->id,
            'amount' => $grossAmount,
            'pay_time' => Carbon::now(),
            'desc' => $orderId,
        ]);
        $feeId->update([
            'remaining_fee' => $feeId->remaining_fee - $grossAmount,
        ]);
        if($feeId->remaining_fee==0){
            $feeId->update(['status'=>0]);
            ClubWaitingList::create(['club_id'=>$this->club->id,"status"=>1,"message"=>"","Approver"=>""]);   
        
          }
        session()->flash('success', 'Pembayaran berhasil.');
        }else{
            session()->flash('error', 'Pembayaran gagal.');
        }
    } else {
       
    }
        }
    }
    public function payBill($bill)
    {
    
        if($this->pgt){
            $pgt = PaymentGatewayToken::find($this->pgt);
           
        }else{
            $pgt = PaymentGatewayToken::where('club_id', $this->club->id)
            ->where('created_at', '>', Carbon::now()->subMinutes(15))
            ->first();
        }
        
        if($this->snapPay || $pgt){
            $this->snapPay = $pgt->snapToken;
            $this->pgt= PaymentGatewayToken::where('snapToken',$this->snapPay)->first()->id;
            $this->dispatch('showSnap', $this->snapPay);
        }else{

            $bill = ClubRegistrationFee::find($bill);
            $bill->update(['status'=>2]);
            
            if (!$bill) {
                session()->flash('error', 'Tagihan tidak ditemukan.');
                return;
            }

        $pg = PaymentGateway::first();
        $this->clientKey = $pg->client_key;
        Config::$serverKey = $pg->server_key;
        Config::$clientKey = $pg->client_key;

        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . now()->format('YmdHis') . '-' . $bill->id,
                'gross_amount' => $bill->remaining_fee,
            ],
           
            'customer_details' => [
                'first_name' => $this->club->name,
                'email' => $this->club->email,
                'phone' => $this->club->phone,
            ],
             [
            'item_details' => [
            'id' => 'REGFEE-' . $pg->id."-" . now()->format('YmdHis'),
            'price' => $bill->remaining_fee,
            'quantity' => 1,
            'name' => 'Biaya Pendaftaran Klub',
        ],
    ],
        ];

        try {
            $this->snapPay = Snap::getSnapToken($params);
            $payment_new=PaymentGatewayToken::create([
                'club_id'=>$this->club->id,
                'payment_gateway_id' => $pg->id,
                'snapToken' => $this->snapPay,
                'order_id'=>"",
                'status' => 1,
            ]);
            $this->pgt=$payment_new->id;
            $this->dispatch('showSnap', $this->snapPay);
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal membuat token: ' . $e->getMessage());
        }
    }
    }
    
    public $pgt;    
    public function paymentError($result)
    {
        $this->club->update(['name'=>"ggal"]);
        dd('gagal', $result);
    }

    public function render()
    {
        
        $bills = ClubRegistrationFee::where('club_id', $this->club->id)->where('status',"!=", 0)->get();
        return view('livewire.club.club-my-bill', [
            'bills' => $bills,
        ]);
    }
}
