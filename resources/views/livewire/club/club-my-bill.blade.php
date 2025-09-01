<div>
    <h2 class="text-xl font-bold mb-4">Daftar Tagihan Saya</h2>

        @if($bills->isEmpty())
            <p>Tidak ada tagihan yang belum dibayar.</p>
            @else
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                     <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Deskripsi</th>
                        <th scope="col" class="px-6 py-3">Jumlah (Rp)</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($isLoading)
                    <div class="absolute inset-0 flex justify-center items-center bg-white/50 z-50">
                        <x-loader />
                    </div>
                    @endif
                    @foreach($bills as $bill)
                        <tr>
                            <td scope="col" class="px-6 py-3">{{ $loop->iteration }}</td>
                            <td scope="col" class="px-6 py-3">Registrasi Keanggotaan</td>
                            <td scope="col" class="px-6 py-3">{{ number_format($bill->remaining_fee) }}</td>
                            <td scope="col" class="px-6 py-3">
                                @if($bill->status == 1)
                                <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-600 ring-1 ring-red-500/10 ring-inset">Belum Lunas</span>
                                @elseif($bill->status == 2)
                                <span class="text-yellow-600 font-semibold">Pending</span>
                                @else
                                <span class="text-green-600 font-semibold">Lunas</span>
                                @endif
                            </td>
                            <td scope="col" class="px-6 py-3">

                                @if($bill->status == 1)
                                <flux:button icon="credit-card" id="payBILL" wire:click="payBill({{ $bill->id }})">Bayar</flux:button>
                                @elseif($bill->status == 2)
                                <flux:button icon="credit-card" id="cekBill" wire:click="cekBill({{ $bill->id }})">Cek Bayar</flux:button>
                                @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
 <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="dummy_client_key"></script>
<script>
    window.addEventListener('showSnap', event => {
        const snapToken = event.detail[0];
        if (typeof snapToken !== 'string') {
            console.error('Token harus string!');
            return;
        }
        snap.pay(snapToken, {

          onSuccess: function(result) {
        console.log('onSuccess:', result);
        alert('Pembayaran berhasil untuk Order ID: ' + result.order_id);
        Livewire.dispatch('paymentSuccess', {result:result});
    },
    onPending: function(result) {
            Livewire.dispatch('paymentPending', {result:result});
            alert('Pembayaran masih pending untuk Order ID: ' + result.order_id);
        },
        onError: function(result) {
            console.log('onError:', result);
            alert('Pembayaran gagal.');
        },
        onClose: function() {
            console.log('Modal pembayaran ditutup.');
            alert('Modal pembayaran ditutup.');
        }

        });
    });
</script>

</div>
