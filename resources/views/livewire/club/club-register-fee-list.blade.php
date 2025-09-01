<div>

    @if (session()->has('message'))

    <flux:callout icon="sparkles" color="green">
        <flux:callout.heading>Alert</flux:callout.heading>
        <flux:callout.text>
            {{ session('message') }}
        </flux:callout.text>
    </flux:callout>
    @endif
    <div class="w-full flex justify-end">

    </div>

    <div class="flex justify-center items-center">

        <flux:navbar >
            <flux:navbar.item  wire:navigate href="/club-administration">Home</flux:navbar.item>
            <flux:navbar.item  wire:navigate href="/club-administration/pending">Belum Diatur
            @if ($wlCount)

            <small class="bg-red-500 flex top-0 right-0 w-[20px] h-[20px] justify-center items-center rounded-lg absolute" style="width: 20px;height: 20px;">
                @if ($wlCount<9)

            {{$wlCount}}
            @else
            9+
            @endif
        </small>
        @endif
        </flux:navbar.item>

            <flux:navbar.item  wire:navigate href="/club-administration/confirm">Konfirmasi Pembayaran
                    @if ($wlConfirmCount)

            <small class="bg-red-500 flex top-0 right-0 w-[20px] h-[20px] justify-center items-center rounded-lg absolute" style="width: 20px;height: 20px;">
                @if ($wlConfirmCount<9)

            {{$wlConfirmCount}}
            @else
            9+
            @endif
        </small>
        @endif
    </flux:navbar.item>
            <flux:navbar.item  wire:navigate href="/club-administration/history">Riwayat</flux:navbar.item>
            <flux:navbar.item  wire:navigate href="/club-administration/setting">Pengaturan</flux:navbar.item>
        </flux:navbar>
    </div>
    <div class="overflow-x-auto mt-5 relative">

        @if($segment=='pending')
        <table id="clubes" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($waitingList as $wl)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $wl->name}}</td>


                        <td class="px-6 py-2">

                                    <flux:button icon="banknotes" wire:click="setFeeClub({{ $wl->id }})">Set Fee</flux:button>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @elseif($segment=='history' || $segment=='confirm')
        <table id="clubes" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Club</th>
                    <th scope="col" class="px-6 py-3">Nominal</th>
                    @if ($segment=='history')
                    <th scope="col" class="px-6 py-3">Status</th>
                    @endif
                    <th scope="col" class="px-6 py-3">Bukti Pembayaran</th>
                    @if($segment=='confirm')
                    <th scope="col" class="px-6 py-3">Konfirmasi</th>
                    @endif
                </tr>
            </thead>
            <tbody>

                @foreach ($waitingList as $wl)
                 <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                     <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $waitingList->firstItem() + $loop->index }}</td>
                     <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $wl->clubRegistrationFee->club->name}}
                         @if ($wl->clubRegistrationFee->club->nick)
                         ({{ $wl->clubRegistrationFee->club->nick}})
                         @endif
                     </td>

                     <td class="px-6 py-2">
                         Rp.
                         {{ number_format($wl->amount) }}

                     </td>
                     <td class="px-6 py-2">
                          @if($segment!='history')
                            @if($wl->status==1)
                            <flux:button icon="banknotes" wire:click="payModal({{ $wl->id }})"></flux:button>
                            @elseif($wl->status==0 || $wl->status==2)
                            <flux:button  wire:click="history({{ $wl->id }})" icon="information-circle"></flux:button>
                            @endif
                            @else
                            @if($wl->status==1)
                            <flux:badge color="green" class="text-xs cursor-pointer hover:bg-gray-300 hover:text-black">Diterima</flux:badge>
                            @elseif($wl->status==0)
                            <flux:badge color="red" class="text-xs cursor-pointer hover:bg-gray-300 hover:text-black">Ditolak</flux:badge>

                            @endif
                            @endif
                     </td>
                     <td class="px-6 py-2">
                         @if($segment!='history')
                         <flux:button icon="check-circle" variant="primary" class="bg-green-600 text-white" wire:click="confirmPay({{ $wl->id }},1)">Terima</flux:button>
                         <flux:button icon="x-circle" variant="danger" class="text-white" wire:click="confirmPay({{ $wl->id }},0)">Tolak</flux:button>
                         @else
                            <flux:button icon="information-circle" wire:click="history({{ $wl->id }})"></flux:button>
                         @endif
                     </td>
                 </tr>
                 @endforeach
            </tbody>
        </table>
          @if(!$waitingList->isEmpty() )
    <div class="mt-5">
        {{ $waitingList->links() }}
    </div>
    @endif
        @elseif($segment=='setting')
        <form class="flex justify-center items-center" wire:submit="setAllRegistrationFee">
            <div class="w-[60%] gap-2 items-center justify-center flex-col">
                <flux:input type="number" wire:model="nominal"/>
                <flux:button type="submit">Save</flux:button>
            </div>
        </form>
        @else
        <table id="clubes" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Fee</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($waitingList as $wl)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $waitingList->firstItem() + $loop->index }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $wl->club->name}}</td>

                        <td class="px-6 py-2">
                            Rp.
                            {{ number_format($wl->fee-($wl->fee-$wl->remaining_fee)) }}
                            {{-- @if($wl->status==0)
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-600 ring-1 ring-blue-500/10 ring-inset">Approved</span>
                            @elseif($wl->status==2)
                            <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-600 ring-1 ring-red-500/10 ring-inset">Rejected</span>
                            @else
                            <span class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-600 ring-1 ring-yellow-500/10 ring-inset">Pending</span>
                            @endif --}}

                        </td>
                        <td class="px-6 py-2">
                            @if($wl->status==1)
                            <flux:button icon="banknotes" wire:click="payModal({{ $wl->id }})"></flux:button>
                            @elseif($wl->status==0)
                            <flux:button  wire:click="history({{ $wl->id }})" icon="information-circle"></flux:button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <div wire:loading >
            <div class=" w-full flex justify-center items-center absolute top-0 left-0 right-0 bottom-0 z-50">
                <flux:icon.loading />
            </div>
        </div>
    </div>

    <flux:modal name="set-pay-club" class="w-full text-center">
        <form wire:submit="setRegistrationFeeClub">

            <flux:input wire:model="payClubName" placeholder="club Name" label="club" />
            <flux:input wire:model="payNominal" readonly placeholder="1000" label="Nominal" class="mb-2"/>
            <flux:modal.close>
                <flux:button variant="ghost" class="mt-5">Cancel</flux:button>
            </flux:modal.close>

            <flux:button type="submit">Save</flux:button>
        </form>
</flux:modal>
    <flux:modal name="pay-club" class="w-full text-center">
        <form wire:submit="transactionClub">
            <flux:input wire:model="payClubName" placeholder="club Name" label="club" readonly/>
            <flux:input wire:model="payNominal" placeholder="1000" label="Nominal" class="mb-2"/>
            <flux:input wire:model="payDate" type="date"  label="Date" class="mb-2"/>

                <flux:input type="file" wire:model="proof" label="Bukti Transaksi (Tangkap Layar Pembayaran)"/>
            <flux:modal.close>
                <flux:button variant="ghost" class="mt-5">Cancel</flux:button>
            </flux:modal.close>

            <flux:button type="submit"  wire:loading.attr="disabled"
                wire.target="proof">Save</flux:button>
        </form>
</flux:modal>
<flux:modal name="modal-detail" class="w-full">
    @if ($segment=="history")
                  Table Detail Pembayaran
        @else
        <div class="text-center">
            <h2 class="text-lg font-bold mb-4">Gambar Pendukung Pembayaran</h2>

            @if ($qrPhoto)
            <img src="{{ $qrPhoto }}" alt="Bukti Pembayaran" class="mx-auto max-h-96 rounded shadow-md mb-4">
            @else
            <p class="text-gray-500 italic mb-4">Bukti transaksi belum tersedia.</p>
            @endif

            <div class=" text-sm mb-4 text-center">
                <p><span class="font-semibold">Nama:</span> {{ $nama ?? '-' }}</p>
                <p><span class="font-semibold">Tanggal:</span> {{ $tanggal_bayar ? \Carbon\Carbon::parse($tanggal_bayar)->format('d M Y ') : '-' }}</p>
            </div>

            <div class="mt-4 flex justify-end">
                <flux:button wire:click="closeModal('modal-detail')">
                    Close
            </flux:button>
        </div>
    </div>
    @endif
</flux:modal>
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

            <flux:button type="button" class="{{ $typeButton!='danger'?'bg-green-600':'' }}" wire:click="confirmPayment" type="{{ $typeButton }}">Ya</flux:button>
        </div>
    </div>

</flux:modal>

