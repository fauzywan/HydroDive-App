<div>
     @if (session()->has('message'))
    <x-message-alert></x-message-alert>
    @endif


    <div class="flex flex-col justify-center items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ auth()->user()->role_id==1?'/event':'/club/my-event' }}" navigate:true>Kompetisi Saya</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="/event/{{$event->id}}/detail" navigate:true>{{$event->name}}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:navbar class="mt-5">
                    @foreach ($navigations as $nav )
                        @if ($nav['no']==$navActive)
                        <flux:navlist.item  wire:click="show({{ $nav['no'] }})" current>{{ $nav['name'] }}</flux:navlist.item>
                        @else
                        <flux:navlist.item  wire:click="show({{ $nav['no'] }})" >{{ $nav['name'] }}</flux:navlist.item>
                        @endif
                    @endforeach
        </flux:navbar>
    </div>
    <x-played-event-heat :eventBerlangsung="$eventBerlangsung" />
    @if ($formShow==1)
<div class="flex w-full mt-2 gap-2">
         <flux:input wire:model.live.debounce.1000ms="keyword" icon="magnifying-glass" placeholder="Search Name" />
           <flux:button icon="plus-circle" wire:click="addNomor">Tambah Nomor</flux:button>
    </div>
    <div class="overflow-x-auto mt-5 relative">
        <table id="events" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class=" px-6 py-3">Nomor</th>
                    <th scope="col" class="px-6 py-3">Acara</th>
                    <th scope="col" class="px-6 py-3">Grup Usia</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($event_numbers as $number)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50
                    even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $number->number}}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $number->category->description }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $number->branches->count() }}</td>
                        <td class="px-6 py-2">
                            {{-- <x-badge-href color="blue" href="/number/{{$number->id}}/edit">Edit</x-badge-href>
                            <span  wire:click="delete({{ $number->id }})">
                                <x-badge-href color="red">Delete</x-badge-href>
                            </span>
                            {{-- <span  wire:click="duplicate({{ $event->id }})">
                                <x-badge-href color="sky" >Duplicate</x-badge-href>
                            </span> --}}
                            <x-badge-href color="green" href="/number/{{$number->id}}/list">detail</x-badge-href>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div wire:loading >
            <div class=" w-full flex justify-center items-center absolute top-0 left-0 right-0 bottom-0 z-50">
                <flux:icon.loading />
            </div>
        </div>
    </div>
    <flux:modal name="delete-branch" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Hapus Cabang Kompetisi?</flux:heading>

                <flux:text class="mt-2">
                    <p>You're about to delete <b>{{ $first_name }}</b></p>
                    <p>This action cannot be reversed.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="button" wire:click="destroy" variant="danger">Delete Athlete</flux:button>
            </div>
        </div>
    </flux:modal>
    @elseif ($formShow==2)

    @elseif ($formShow==3)
     <table id="events" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class=" px-6 py-3">Nama</th>
                    <th scope="col" class="px-6 py-3">Acara</th>
                    <th scope="col" class="px-6 py-3">Grup Usia</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($event->administration as $administration)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50
                    even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                            {{ $administration->athlete->name() }}
                        </td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                            {{ $administration->branch->eventNumber->number }}
                        </td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                            {{ $administration->branch->age->showName() }}
                        </td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                            @if($administration->status==1)
                            <flux:badge color="blue">Aktif</flux:badge>
                            @elseif( $administration->status==-1 || ($administration->status==0 && $administration->status_fee==0))
                            <flux:badge color="red">Tidak Aktif</flux:badge>
                            @else
                            <flux:badge color="blue">Proses Administrasi</flux:badge>
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

    @elseif ($formShow==5)
        <form wire:submit="onOrOff({{ $event->status}})" class="flex  flex-col justify-center">
            <flux:input label="{{$event->status!=1?'Mulai':'Selesai'}}" value="{{ date('Y-m-d H:i') }}" type="datetime-local" wire:model.live="competition_date" />
        </form>
         <flux:button class="mt-5" type="button" wire:click="confimONFF">
        {{ $event->status == 1 ? 'Nonaktifkan' : 'Aktifkan' }}
    </flux:button>
        @elseif ($formShow==4)
       <table id="events" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Acara</th>
                    <th scope="col" class=" px-6 py-3">Babak</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
              @foreach ($event->sessions->sortByDesc('status') as $heat)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50
                    even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                             {{ $heat->branch->eventNumber->number }}
                             ( {{ $heat->branch->age->name }})
                        </td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                           {{ $heat->name }}  @if($heat->status==-1) <span class="text-green-500"> [Selesai] </span>@endif
                        </td>

                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                            <flux:badge color="green" wire:click="detailHeat('{{ $heat->id }}', '{{ $heat->branch->is_final }}')"
                                class="text-xs cursor-pointer hover:bg-gray-300 hover:text-black">detail</flux:badge>
                                @if($heat->status==1)
                                <flux:badge color="red"
                                wire:click="EndtEvent('{{ $heat->id }}','{{  $heat->branch->administration->where('status',1)->count() }}')"
                                    class="text-xs cursor-pointer hover:bg-gray-300 hover:text-black">Selesai</flux:badge>
                                @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

        @elseif ($formShow==7)
         <div class="flex justify-center mt-5">
    @if($event->poster)
    <div class="relative group">
        <img src="{{ asset('storage/event/poster/' . $event->poster) }}" alt="Poster Event" class="max-w-sm rounded shadow-lg">

        <!-- Gradient overlay -->
        <div class="absolute bottom-0 left-0 w-full h-20 bg-gradient-to-t from-black to-transparent opacity-0 group-hover:opacity-80 transition-opacity rounded-b"></div>

        <!-- Tombol download -->
        <button wire:click="downloadPoster"
                class="absolute bottom-2 mr-2 ml-2 right-0 left-0 z-10 px-3 py-1 bg-white text-black rounded shadow hover:bg-gray-200 transition">
            Download
        </button>
    </div>
</div>
                @else
                    <p class="text-gray-500">Poster belum tersedia</p>
                @endif
            </div>

        @elseif ($formShow==6)
       <table id="events" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Club</th>
                    <th scope="col" class=" px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($event->registered->where('status',1) as $club)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50
                    even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $club->club->name }}
                        </td>
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white"><flux:badge color="red" wire:click="deleteClub('{{ $club->id }}')">hapus</flux:badge>
                        </td>


                    </tr>
                @endforeach
                 @foreach ($event->registered->where('status',2) as $club)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50
                    even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $club->club->name }}
                        </td>
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                            <flux:badge color="red" wire:click="deleteClub('{{ $club->id }}')">tolak</flux:badge>
                            <flux:badge color="green" wire:click="acceptClub('{{ $club->id }}')">terima</flux:badge>
                        </td>


                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
        <flux:modal name="modal-number" class="min-w-[22rem]">
             <form wire:submit="{{ $formType }}" >
                 <flux:input wire:model="number" type="number" label="Nomor Kegiatan"/>
                    <div class="mt-2 items-center">
                        <flux:input label="Nama Cabang" class="col-span-2" type="string" readonly wire:model="name_category" wire:click="searchCategory" icon:trailing="magnifying-glass"/>
                    </div>
                    <flux:button type="submit" class="mt-2">Save</flux:button>
                </form>
        </flux:modal>
         <flux:modal name="search-category" class="min-w-[22rem]">
    <div class="flex flex-col justify-between items-center mt-5 mt-2">
        <flux:header>Search Category</flux:header>
        <div class="flex justify-between items-center mt-5 mt-2">
            <flux:input wire:model.live.debounce.1000ms="keyword_category" placeholder="Nama" />
            <flux:button wire:click="searchKeywordCategory">Search</flux:button>
        </div>

        @if ($categorySearch)
        <div class="flex flex-col mt-2">
            @foreach ($categorySearch as $cs)
            <flux:badge color="zinc" class="cursor-pointer mb-2" wire:click="selectOption('{{ $cs->id }}','{{ $cs->description }}','{{ $cs->relay }}')">{{ $cs->description }}</flux:badge>
            @endforeach
        </div>
            @endif

    </div>
</flux:modal>
<flux:modal name="confirm-onoff" class="min-w-[22rem]" wire:model="showConfirmOnOff">
    <div class="space-y-4">

        <flux:heading size="lg">
            Konfirmasi {{ $event->status == 1 ? 'Nonaktifkan' : 'Aktifkan' }} Kompetisi
        </flux:heading>
        <flux:text>
            Apakah Anda yakin ingin {{ $event->status == 1 ? 'menonaktifkan' : 'mengaktifkan' }} kompetisi ini?
            <br />
            Waktu yang Anda tetapkan: <b>{{ $competition_date }}</b>
        </flux:text>
        <div class="flex justify-end gap-2">
            <flux:modal.close>
                <flux:button variant="ghost">Batal</flux:button>
            </flux:modal.close>
            <form wire:submit.prevent="onOrOff({{ $event->status }})">
                <flux:button type="submit" variant="danger">
                    Ya, {{ $event->status == 1 ? 'Nonaktifkan' : 'Aktifkan' }}
                </flux:button>
            </form>
        </div>
    </div>
</flux:modal>
<flux:modal name="modalClub" class="min-w-[22rem]" >
    <div class="space-y-4">

        <flux:heading size="lg">
            Konfirmasi Pendaftaran Club
        </flux:heading>
        <flux:text>
            Lanjutkan Proses
        </flux:text>
        <div class="flex justify-end gap-2">
            <flux:modal.close>
                <flux:button variant="ghost">Batal</flux:button>
            </flux:modal.close>
            <form wire:submit.prevent="updateClub">
                <flux:button type="submit" variant="danger">
                    Ya, Lanjutkan
                </flux:button>
            </form>
        </div>
    </div>
</flux:modal>
</div>
