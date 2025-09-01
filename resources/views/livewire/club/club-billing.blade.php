<div>
    @if (session()->has('message'))
    <x-message-alert></x-message-alert>
    @endif

        <div class="flex justify-center items-center">
            <flux:navbar >
                  @foreach ($navigations as $nav )
                    @if ($nav['no']==$navActive)
                    <flux:navlist.item  wire:click="show({{ $nav['no'] }})" data-current>{{ $nav['name'] }}</flux:navlist.item>
                    @else
                    <flux:navlist.item  wire:click="show({{ $nav['no'] }})" >{{ $nav['name'] }}</flux:navlist.item>
                    @endif
                @endforeach
            </flux:navbar>
    </div>

    <div class="overflow-x-auto mt-6 relative shadow-md sm:rounded-lg"> {{-- Added shadow and border-radius --}}

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400"> {{-- Slightly lighter header background --}}
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3"> Nama</th>
                    <th scope="col" class="px-6 py-3">Nominal</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3 text-center">Actions</th> {{-- Centered Actions header --}}
                </tr>
            </thead>
            <tbody>
                @forelse ($billings as $billing)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200"> {{-- Added hover effect --}}
                        {{-- <td class="px-6 py-3 font-medium text-gray-900 dark:text-white">
                            @if ($billing->type==1)
                            <input type="checkbox"  wire:click="selectedMoreBillings('{{ $billing->id }}','{{ $billing->nominal }}')" class="form-checkbox text-blue-600"/>
                            @endif
                        </td> --}}
                        <td class="px-6 py-3 font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}</td> {{-- Increased vertical padding --}}
                        <td class="px-6 py-3 text-gray-700 dark:text-gray-300">{{ $billing->name }}</td>
                        <td class="px-6 py-3 text-gray-700 dark:text-gray-300 font-semibold">Rp{{ number_format($billing->nominal, 0, ',', '.') }}</td> {{-- Added font-semibold for nominal --}}
                        <td class="px-6 py-3">
                            @if (!$billing->status) {{-- Logical change: If status is TRUE, it's Lunas --}}

                            @if ($billing->status_2==2)
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100">
                                Pending
                            </span>
                            @else
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100">
                                Lunas
                            </span>
                                @endif
                                @else

                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100">
                                    Belum Lunas
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-center"> {{-- Centered actions column content --}}
                            <div class="flex items-center justify-center space-x-2"> {{-- Flexbox for spacing buttons --}}
                            @if($billing->status!=0)
                            <flux:button class="text-xs bg-green-500" variant="primary" icon="banknotes" wire:click="payBilling({{ $billing->id}},{{$billing->type }})">
                                Bayar
                            </flux:button>
                            @else
                            <flux:button class="text-xs bg-green-500" variant="primary" icon="banknotes" wire:click="qrBill({{ $billing->id}},{{ $billing->type }})">
                                Detail
                            </flux:button>

                            @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 italic">
                            Tidak ada data billing tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
            @if ($morePay!=[])
           <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200"> {{-- Added hover effect --}}
                <td colspan="4" class="px-6 py-3 text-center">
                </td>
                <td class="px-6 py-3 text-center">
                    Rp{{ number_format($this->billingPay) }}
                </td>
                <td class="px-6 py-3 text-center">
                    <flux:button type="submit" wire:click="payMoreBillingModal">Bayar</flux:button>
                </td>
            </tr>
            @endif
        </table>
        <div wire:loading class="absolute inset-0 bg-white bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75 flex justify-center items-center rounded-lg">
               <div class="flex justify-center items-center space-x-2">
            <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
            <span class="text-blue-500">Memuat data...</span>
        </div>
        </div>

        <flux:modal name="modal-form" class="w-full" >
            <form wire:submit="payIt" >
                <flux:input wire:model="transaction_name" type="text" label="Transaksi" class="mbt-2"  readonly/>

                <flux:input wire:model="transaction_nominal" type="number" label="Nominal Pembayaran" readonly/>

                <flux:select wire:model.live="payment_method_select" label="Payment Method" wire:key="payment_method_select">
                    @foreach ($paymentMethods as $pm)
                    <flux:select.option value="{{ $pm->id }}">{{$pm->name()}}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:input type="date" wire:model="pay_time" label="Tanggal Pembayaran"/>
                <div class="flex ">
                    <flux:input wire:model="transaction_address" type="text" label="Nomor Tujuan" class="mbt-2"  readonly/>
                    <flux:button class="mt-5" type="button" icon="information-circle"  wire:click="detailBilling(0)"></flux:button>
                </div>
                <flux:input type="file" wire:model="proof" label="Bukti Transaksi (Tangkap Layar Pembayaran)"/>
            <div class="flex mt-2 flex gap-3 mr-2">
                <flux:spacer />
                @if ($proof!=null)

                <flux:button class="cursor-pointer"
                wire:loading.attr="disabled"
                wire.target="proof"
                type="submit"
                >Save</flux:button>
                @else
                 <flux:button class="cursor-pointer"
                wire.target="proof"
                type="button"
                disabled
                >Unggah Bukti Lebih Dulu</flux:button>
                @endif
            </div>
        </form>
        </flux:modal>
    </div>
    <flux:modal name="modal-detail" class="w-full">
    <div class="text-center">
        <h2 class="text-lg font-bold mb-4">{{ $modalTitle }}</h2>

        @if ($qrPhoto)
            <img src="{{ $qrPhoto}}" alt="Bukti Pembayaran" class="mx-auto max-h-96 rounded shadow-md">
        @else
            <p class="text-gray-500 italic">Bukti transaksi belum tersedia.</p>
        @endif

        <div class="mt-4 flex justify-end">
            <flux:button wire:click="closeModal('modal-detail')">
                Close
            </flux:button>
        </div>
    </div>
</flux:modal>

</div>
