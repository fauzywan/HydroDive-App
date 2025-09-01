<div>
    {{-- Header Judul + Info --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
            Verifikasi Administrasi
        </h1>
        <flux:button type="button" icon="information-circle" wire:click="openModal('info-modal')">
            Info
        </flux:button>
    </div>

    {{-- Ringkasan Card --}}
 <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700"
         wire:click="setFilter('all')">
        <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Administrasi</h2>
        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">
            {{ $allTransactions->count() }}
        </p>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700"
         wire:click="setFilter('finish')">
        <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Sudah Diverifikasi</h2>
        <p class="text-2xl font-bold text-green-600 mt-2">
            {{ $transactionsFinished->count() }}
        </p>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700"
         wire:click="setFilter('pending')">
        <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Perlu Tinjauan</h2>
        <p class="text-2xl font-bold text-yellow-500 mt-2">
            {{ $transactionsPending->count() }}
        </p>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4">
        <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Nominal</h2>
        <p class="text-2xl font-bold text-blue-600 mt-2">
            @if($filter=='all' || $filter=='finish')
            Rp. {{ number_format($transactions->where('status','!-',0)->sum('amount')) }}
            @else
            Rp. {{ number_format($transactions->sum('amount')) }}
            @endif
        </p>
    </div>
</div>


    {{-- Pesan Sukses/Error --}}
    @if (session()->has('message'))
        <x-message-alert></x-message-alert>
    @endif

    {{-- Tabel Data --}}
    <table id="clubes" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3">Name</th>
                <th scope="col" class="px-6 py-3">Fee</th>
                 <th scope="col" class="px-6 py-3">Bukti Pembayaran</th>
                 <th scope="col" class="px-6 py-3">Actions / Status</th>
            </tr>
        </thead>
        <tbody  wire:poll.5s="loadTransactions">
            {{-- Grup --}}
            @foreach ($transactions->where('group_token', '!=', '')->unique('group_token') as $transaksi)
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}</td>
                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                        {{$transaksi->administration->club->name ." (".$transaksi->group_token.")" }}
                    </td>
                    <td class="px-6 py-2">
                        Rp. {{ number_format($transactions->where('group_token',$transaksi->group_token)->sum('amount')) }}
                    </td>
                    <td class="px-6 py-2">
                        <flux:button type="button" wire:click="showGroupDetails('{{ $transaksi->group_token }}')" icon="information-circle">
                            Lihat Detail
                        </flux:button>
                        <flux:button type="button" wire:click="history('{{ $transaksi->payment_proof }}')" icon="information-circle"></flux:button>
                    </td>
                    <td class="px-6 py-2">
                    @if($transaksi->status == 2)
                        <flux:button icon="check-circle" variant="primary" class="bg-green-600 text-white" wire:click="confirmGroupPay('{{ $transaksi->group_token }}', 1)">
                            Terima
                        </flux:button>
                        <flux:button icon="x-circle" variant="danger" class="text-white" wire:click="confirmGroupPay('{{ $transaksi->group_token }}', 0)">
                            Tolak
                        </flux:button>
                        @endif
                    </td>
                </tr>
            @endforeach

            {{-- Individu --}}
            @foreach ($transactions->where('group_token',"") as $transaksi)
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{$loop->iteration }}</td>
                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                        {{ $transaksi->administration->athlete->name() .'('.$transaksi->administration->event->name.')' }}
                    </td>
                    <td class="px-6 py-2">
                        Rp. {{ number_format($transaksi->amount) }}
                    </td>
                    <td class="px-6 py-2">
                        <flux:button type="button" wire:click="history('{{ $transaksi->payment_proof }}')" icon="information-circle"></flux:button>
                    </td>
                    <td class="px-6 py-2">
                            @if($transaksi->status == 2)
                        <flux:button icon="check-circle" variant="primary" class="bg-green-600 text-white" wire:click="confirmPay({{ $transaksi->id }},{{ $transaksi->administration_id }},1)">
                            Terima
                        </flux:button>
                        <flux:button icon="x-circle" variant="danger" class="text-white" wire:click="confirmPay({{ $transaksi->id }},{{ $transaksi->administration_id }},0)">
                            Tolak
                        </flux:button>
                        @else
                        @if($transaksi->status == 0)
                        <span class=" px-2 py-2 rounded-[12px] text-red-500 bg-red-500/10">Ditolak</span>
                        @elseif($transaksi->status == 1)
                        <span class=" px-2 py-2 rounded-[12px] text-green-500 bg-green-500/10">Diterima</span>
                        @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Modal Bukti Pembayaran --}}
    <flux:modal name="modal-detail" class="w-full">
        <div class="text-center">
            <h2 class="text-lg font-bold mb-4">Gambar Pendukung Pembayaran</h2>
            @if ($qrPhoto)
                <img src="{{ $qrPhoto }}" alt="Bukti Pembayaran" class="mx-auto max-h-96 rounded shadow-md mb-4">
            @else
                <p class="text-gray-500 italic mb-4">Bukti transaksi belum tersedia.</p>
            @endif
            <div class="mt-4 flex justify-end">
                <flux:button wire:click="closeModal('modal-detail')">Close</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Modal Konfirmasi --}}
    <flux:modal name="confirm-modal" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Konfirmasi Aksi</flux:heading>
                <flux:text class="mt-2">
                    <p>Tekan tombol Ya untuk melanjutkan aksi</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="button" class="{{ $typeButton!='danger'?'bg-green-600':'' }}" wire:click="confirmPayment" type="{{ $typeButton }}">
                    Ya
                </flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Modal Detail Grup --}}
    <flux:modal name="modal-group-detail" class="w-full max-w-lg">
        <div class="p-6">
            <h2 class="text-lg font-bold mb-4">Detail Transaksi Grup</h2>
            <ul class="space-y-2">
                @foreach($selectedGroupTransactions as $trx)
                    <li>
                        {{ $trx->administration->athlete->name() }} - Rp. {{ number_format($trx->amount) }}
                    </li>
                @endforeach
            </ul>
            <div class="mt-4 flex justify-end">
                <flux:button wire:click="closeModal('modal-group-detail')">Tutup</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Modal Info Halaman --}}
    <flux:modal name="info-modal" class="w-full max-w-lg">
        <div class="p-6">
            <h2 class="text-lg font-bold mb-4">Informasi Halaman</h2>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                Halaman ini digunakan untuk meninjau dan memverifikasi pembayaran administrasi
                yang dilakukan oleh klub maupun peserta individu yang ingin berpartisipasi pada lomba.
                <br><br>
                Melalui halaman ini, Anda dapat:
            </p>
            <ul class="list-disc pl-6 mt-3 text-gray-600 dark:text-gray-300">
                <li>Melihat total administrasi dan nominal pembayaran.</li>
                <li>Meninjau detail transaksi dan bukti pembayaran.</li>
                <li>Menyetujui atau menolak pembayaran sesuai hasil verifikasi.</li>
            </ul>
            <div class="mt-6 flex justify-end">
                <flux:button wire:click="closeModal('info-modal')">Tutup</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
