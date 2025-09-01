<div>
    @if (session()->has('message'))
    <x-message-alert></x-message-alert>
    @endif
    @if ($eventClub->status==1)
     <section class="flex justify-center items-center">

        <flux:breadcrumbs>
            <flux:breadcrumbs.item>Kompetisi</flux:breadcrumbs.item>
            <flux:breadcrumbs.item wire:navigate href="/club/event">Daftar </flux:breadcrumbs.item>
            <flux:breadcrumbs.item wire:navigate href="/club/{{ $event->id }}/event">
                {{ $event->name }}
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </section>
    <section class="flex max-md:flex-col items-start mt-2">
        <div class="w-full md:w-[220px] pb-4 me-10">
            <flux:navlist>
                @foreach ($navigations as $nav )
                    @if ($nav['no']==$navActive)
                    <flux:navlist.item  wire:click="show({{ $nav['no'] }})" current>{{ $nav['name'] }}</flux:navlist.item>
                    @else
                    <flux:navlist.item  wire:click="show({{ $nav['no'] }})" >{{ $nav['name'] }}</flux:navlist.item>
                    @endif
                @endforeach
            </flux:navlist>
        </div>
            <flux:separator class="md:hidden" />
        <div class="w-full relative">
            @if($formShow==1)
                <div class="flex-1 max-md:pt-6 self-stretch mb-5">
                    <x-select-list-mode :type="$typeView"></x-select-list-mode>
                </div>
                @if ($typeView=='card')
                <div class="grid grid-cols-1 sm:grid-cols-1  md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($event->branches->where('status',1) as $branch)
                    <x-event-branch-card :branch="$branch"
                    ></x-event-branch-card>
                    @endforeach
                </div>
                            @else
                              <table id="branch->" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">

                                            #</th>
                                        <th scope="col" class="px-6 py-3">Nama</th>
                                        <th scope="col" class="px-6 py-3">Grup Usia</th>
                                        <th scope="col" class="px-6 py-3">Kapasitas</th>
                                        <th scope="col" class="px-6 py-3">Kuota Per Klub</th>
                                        <th scope="col" class="px-6 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no=1;@endphp
                                    @foreach ($event->numbers as $numbers)
                                    @foreach ($numbers->branches->where('status',1) as $branch)

                                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50
                                        even:dark:bg-gray-800 border-b dark:border-gray-700">
                                            {{-- <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $events->firstItem() + $loop->index }}</td> --}}
                                            <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{$no+=1}}</td>
                                            <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{$numbers->category->description}}</td>
                                            <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{$branch->age->name}}  ({{ $branch->groupAge() }})</td>
                                            <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{$branch->administration->count()}}/{{ $branch->capacity }}</td>
                                            <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                                                {{ $event->club_id==auth()->user()->club->id?'': $branch->administration->where('club_id',auth()->user()->club->id)->count()."/" }}
                                                {{$branch->capacity_per_club}}</td>

                                            <td class=" text-gray-600 dark:text-gray-300"><flux:badge color="green" wire:navigate href="/event/{{ $branch->id}}/partisipan" class="text-xs cursor-pointer hover:bg-gray-300 hover:text-black">Atlet</flux:badge></td>

                                        </tr>
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                            @endif

            @elseif($formShow==2)
            <table id="branch->" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 w-full">
                                  <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                          <th scope="col" class="px-6 py-3" >

                                              @if ($event->administration->where('status_fee',1)->where('club_id',$clubId)->count()>0 )
                                            <input type="checkbox" wire:model="selectAll" wire:click="toggleSelectAll">
                                            @endif
                                        </th>
                                          <th scope="col" class="px-6 py-3" >#</th>
                                          <th scope="col" class="px-6 py-3">Nama</th>
                                          <th scope="col" class="px-6 py-3">Tagihan</th>
                                          <th scope="col" class="px-6 py-3">Status</th>
                                          <th scope="col" class="px-6 py-3">Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>

                                      @foreach ($event->administration->where('status_fee',1)->where('club_id',$clubId)   as $administration)
                                          <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50
                                          even:dark:bg-gray-800 border-b dark:border-gray-700">
                                              {{-- <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $events->firstItem() + $loop->index }}</td> --}}
                                              <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                                                @if ($administration->status!=2 && $administration->status_fee==1)

                                                <input type="checkbox"
                                                wire:model="selectedAdministrations"
                                                wire:click="updateSelected('{{ $administration->fee }}','{{ $administration->id }}')"
                                                value="{{ $administration->id }}">
                                                @endif
                                              </td>
                                              <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{$loop->iteration}}</td>
                                              <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{$administration->athlete->name()}}</td>
                                              <td class="px-6 py-2 text-gray-600 dark:text-gray-300"> Rp{{number_format($administration->fee)}}</td>
                                              <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                                                @if($administration->status_fee==0 && $administration->status==1)
                                                <flux:badge color="green">Lunas</flux:badge>
                                                @elseif($administration->status_fee==0 && $administration->status=2)
                                                <flux:badge color="yellow">Pending</flux:badge>
                                                @else
                                                <flux:badge color="red">Belum Lunas</flux:badge>
                                                @endif
                                            </td>
                                              <td>
                                             <form wire:submit="payTransaction('{{ $administration->id }}')">
                                                 <flux:button type="submit">Bayar</flux:button>
                                                </form>
                                            </td>
                                          </tr>
                                      @endforeach
                                      <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50
                                          even:dark:bg-gray-800 border-b dark:border-gray-700"><td class="px-6 py-2 text-center" colspan=3 ><b>Total</b></td>
                                    <td class="px-6 py-2" colspan=3 >Rp{{number_format($event->administration->where('status_fee',1)->where('club_id',$clubId)->sum('fee'))}}</td>

                                </tr>
                                    @if (count($selectedAdministrations) >0 &&$event->administration->where('status_fee',1)->where('club_id',$clubId)->count()>0 )

                                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50
                                    even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <td class="px-6 py-2 text-center" colspan=2 ><b>Total Bayar</b></td>
                                    <td class="px-6 py-2 text-center" colspan=3 >
                                        Rp{{number_format($nominalSelected)}}
                                            <td>
                                                <form wire:submit="payMoreTransaction">

                                                 <flux:button type="submit">Bayar</flux:button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endif
                                </tbody>
                              </table>

            @elseif($formShow==3)
              <div class="w-full flex justify-end mb-2">
                <flux:button icon:trailing="chevron-down" wire:click="addAthlete">Add Athlete</flux:button>
        </div>
          <table id="branch->" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 w-full">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                      <tr>
                                        <th scope="col" class="px-6 py-3">#</th>
                                        <th scope="col" class="px-6 py-3">Nama</th>
                                        <th scope="col" class="px-6 py-3">Umur</th>
                                        <th scope="col" class="px-6 py-3">Kompetisi</th>
                                        <th scope="col" class="px-6 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($event->administration->where('club_id',$clubId) as $administration)
                                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50
                                        even:dark:bg-gray-800 border-b dark:border-gray-700">
                                            {{-- <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $events->firstItem() + $loop->index }}</td> --}}
                                            <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{$loop->iteration}}</td>
                                            <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{$administration->athlete->name()}}</td>
                                            <td class="px-6 py-2 text-gray-600 dark:text-gray-300"> {{$administration->athlete->getAge()}}</td>
                                            <td class="px-6 py-2 text-gray-600 dark:text-gray-300"> {{$administration->branch->name}}</td>
                                            <td class="px-6 py-2 text-gray-600 dark:text-gray-300"><flux:button variant="primary" wire:navigate href="/athlete/{{ $administration->athlete_id}}/profile">Detail</flux:button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <flux:modal name="modal-form" class="w-full" >
                            <form wire:submit="savePartisipan" >

                                <flux:select wire:model="athlete_select" label="Nama Atlet" wire:key="athlete_select">
                                    @foreach (auth()->user()->club->athletes as $fc)
                                    <flux:select.option value="{{ $fc->id }}">{{$fc->name()}}</flux:select.option>
                                    @endforeach
                                </flux:select>
                                <flux:select wire:model="branch_select" label="Cabang Kompetisi" wire:key="branch_select">
                                    @foreach ($event->branches as $b)
                                    <flux:select.option value="{{ $b->id }}">{{$b->name}}</flux:select.option>
                                    @endforeach

                                </flux:select>


        <div class="flex mt-2 flex gap-3 mr-2">
            <flux:spacer />

            <flux:button class="cursor-pointer"
            type="submit">Save</flux:button>
        </div>
    </form>
    </flux:modal>
            @elseif($formShow==5)
                    <table id="branch->" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">#</th>
                                <th scope="col" class="px-6 py-3">nomor</th>
                                <th scope="col" class="px-6 py-3">Perlombaan</th>
                                <th scope="col" class="px-6 py-3">Total Grup</th>
                                <th scope="col" class="px-6 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($event->numbers as $number)
                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50
                                even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    {{-- <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $events->firstItem() + $loop->index }}</td> --}}
                                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{$loop->iteration}}</td>
                                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{$number->number}}</td>
                                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{$number->category->description}}</td>
                                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{$number->branches->count()}}</td>
                                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300"></td>

                                </tr>
                            @endforeach
                        </tbody>
                </table>
            @elseif($formShow==4)
            @if(auth()->user()->club->id==$event->club_id)
                <div class="w-full flex justify-end mb-2">
                <flux:button icon:trailing="chevron-down" wire:click="addSession">Add Session</flux:button>
            @endif
        </div>
        <table class="min-w-full border border-gray-300 rounded-md overflow-hidden">
    <thead class="bg-gray-100">
        <tr>
            <th class="py-2 px-4 border-b border-gray-300 text-left">Nama</th>
            <th class="py-2 px-4 border-b border-gray-300 text-left">Cabang</th>
            <th class="py-2 px-4 border-b border-gray-300 text-left">Line</th>
            <th class="py-2 px-4 border-b border-gray-300 text-left">Best Of</th>
            <th class="py-2 px-4 border-b border-gray-300 text-left">Status</th>
            <th class="py-2 px-4 border-b border-gray-300 text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($event->sessions as $session)
            <tr class="hover:bg-gray-50">
                <td class="py-2 px-4 border-b border-gray-300">{{ $session->name }}</td>
                <td class="py-2 px-4 border-b border-gray-300">{{ $session->branch->name }}</td>
                <td class="py-2 px-4 border-b border-gray-300">{{ $session->capacity }}</td>
                <td class="py-2 px-4 border-b border-gray-300">{{ $session->elimination }}</td>
                <td class="py-2 px-4 border-b border-gray-300 text-sm">
                    @if ($session->status)
                        <span class="text-green-600 font-semibold">Aktif</span>
                    @else
                        <span class="text-red-600 font-semibold">Nonaktif</span>
                    @endif
                </td>
                <td class="py-2 px-4 border-b border-gray-300 text-center space-x-2">
                    {{-- <flux:button icon="pencil" size="sm" wire:click="editSession({{ $session->id }})" /> --}}
                    {{-- <flux:button icon="trash" size="sm" variant="destructive" wire:click="deleteSession({{ $session->id }})" /> --}}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="py-4 text-center text-gray-500">Belum ada sesi yang ditambahkan.</td>
            </tr>
        @endforelse
    </tbody>
</table>


<flux:modal name="modal-session" class="w-full">
    <form wire:submit.prevent="saveSession">

        <!-- Nama Sesi -->
        <flux:input label="Nama Sesi" wire:model.defer="sessionForm.name" placeholder="Contoh: Sesi Penyisihan 1" />

        <!-- Cabang Kompetisi -->
        <flux:select wire:model.defer="sessionForm.branch_id" label="Cabang Kompetisi">
            @foreach ($event->branches as $branch)
                <flux:select.option value="{{ $branch->id }}">{{ $branch->name }}</flux:select.option>
            @endforeach
        </flux:select>

        <!-- Kapasitas -->
        <flux:input type="number" label="Kapasitas Per Match" wire:model.defer="sessionForm.capacity" placeholder="Masukkan jumlah kapasitas" />

        <!-- Elimination -->
        <flux:input type="number" label="Jumlah Eliminasi" wire:model.defer="sessionForm.elimination" placeholder="Masukkan jumlah eliminasi" />

        <!-- Status -->


        <!-- Tombol Simpan -->
        <div class="flex justify-end mt-4">
            <flux:button type="submit">Simpan Sesi</flux:button>
        </div>
    </form>
</flux:modal>

            @endif

     <div wire:loading class="absolute inset-0 bottom-0  flex justify-center items-center rounded-lg">
                <div class="flex justify-center items-center space-x-2 w-full h-full">
                <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
            <span class="text-blue-500">Memuat data...</span>
        </div>
        </div>
        </div>
    </section>

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

                <flux:button class="cursor-pointer"
                wire:loading.attr="disabled"
                wire.target="proof"
                type="submit"
                >Pay</flux:button>
            </div>
        </form>
        </flux:modal>
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
        @else
        <div class="flex justify-center items-center min-h-[80dvh]">
            <div class="text-center">
            @if ($eventClub->status==-1)
                <h1 class="text-2xl font-bold ">Permintaan Tidak Disetujui</h1>
                <p class="text-md mt-2 px-3 py-5 rounded-[8px] bg-red-400/10 text-red-400">Anda Dapat Menghubungi Pihak Penyelenggara Untuk Meminta Konfirmasi Persetujuan Pendaftaran</p>
                @else
                <h1 class="text-2xl font-bold ">Menunggu Persetujuan</h1>
                <p class="text-md mt-2 px-3 py-5 rounded-[8px] bg-blue-400/10 text-blue-400">Anda Dapat Menghubungi Pihak Penyelenggara Untuk Meminta Konfirmasi Persetujuan Pendaftaran</p>
                @endif
                <flux:button class="mt-4" wire:navigate href="/club/event">
                    Kembali ke Daftar Kompetisi
                </flux:button>
                @if ($eventClub->status==-1)

                <flux:button  class="cursor-pointer bg-blue-500" wire:click="registerEvent({{   $eventClub->id }})" class="mt-2">
                    Daftar Ulang
                </flux:button>
                @endif
            </div>
    @endif

</div>
