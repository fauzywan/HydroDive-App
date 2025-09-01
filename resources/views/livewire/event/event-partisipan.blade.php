<div>

    <style>
        table tbody td:nth-child(3),
        table thead th:nth-child(3)
        {
            text-align: center;
        }
    </style>
      <div class="flex justify-between items-center mb-5 w-full">
        <a href="/club/{{ $event->id }}/event" wire:navigate class="flex items-center text-blue-600 hover:underline">
            <flux:icon.chevron-left class="w-5 h-5 mr-1" />
            Kembali
        </a>

        <!-- Breadcrumbs -->
        <flux:breadcrumbs>
            <flux:breadcrumbs.item>Kompetisi</flux:breadcrumbs.item>
            <flux:breadcrumbs.item wire:navigate href="/club/event">Daftar </flux:breadcrumbs.item>
            <flux:breadcrumbs.item wire:navigate href="/club/{{ $event->id }}/event">
                {{ $event->name }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item >
                {{ $branch->name }}
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    <div>
    </div>
    </div>
       @if (session()->has('message'))
    <x-message-alert></x-message-alert>
    @endif


    <div class="mt-5 grid-cols-3 grid gap-2">
        <flux:callout icon="users" color="blue">
            <flux:callout.heading>Total Athlete</flux:callout.heading>
            <flux:callout.text>
                <b>{{ $branch->administration->count() }}</b>
            </flux:callout.text>
        </flux:callout>
        <flux:callout icon="users" color="green">
            <flux:callout.heading>Kuota</flux:callout.heading>

            <flux:callout.text>
                {{ $branch->kuota()}}
            </flux:callout.text>
        </flux:callout>
        <flux:callout icon="users" color="pink">
            <flux:callout.heading>Tagihan</flux:callout.heading>
            <flux:callout.text>
                {{ $branch->administrationPay()}}
            </flux:callout.text>
        </flux:callout>
    </div>
    <div class="flex w-full mt-2 gap-2">
         <flux:input wire:model.live.debounce.1000ms="keyword" icon="magnifying-glass" placeholder="Search Name" />
         <div class="flex w-full">
            @if($event->status==1)
               <flux:button icon="plus-circle" wire:click="modalAthlete" >Tambah Atlet</flux:button>
       @endif
               {{-- @if($club)
        <div class="w-full flex justify-end">
            @if ($club->status==1)
            @endif
        </div>
        @endif --}}
    </div>
    </div>
  <div class="overflow-x-auto mt-5 relative">
        <table id="branch->" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Nama</th>
                    <th scope="col" class="px-6 py-3">Umur</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($partisipan as $partisipan)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50
                    even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $partisipan->athlete->name() }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $partisipan->athlete->getAge() }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                            @if ($partisipan->status_fee==1)
                                Selesaikan Administrasi
                                @else
                                Aktif
                            @endif
                        </td>

                        <td class="px-6 py-2">
                            <x-badge-href color="green" href="/athlete/{{$partisipan->athlete->id}}/profile">detail</x-badge-href>
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
     {{-- MODAL DELETE --}}

    <flux:modal name="delete-event" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete Event?</flux:heading>

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

                <flux:button type="button" wire:click="destroy" variant="danger">Delete event</flux:button>
            </div>
        </div>

    </flux:modal>
    <flux:modal name="search-athlete" class="min-w-[22rem]">
    <div class="flex flex-col justify-between items-center mt-5 gap-2">
        <flux:header>Search Athlete Name</flux:header>
        <div class="flex justify-between items-center mt-5 gap-2">
            <flux:input wire:model="searchAthlete" placeholder="athlete Name"/>
            <flux:button wire:click="searchingAthlete">Search</flux:button>
        </div>
        @if($athleteSearch)
        @foreach ($athleteSearch as $sc)
        <div class="flex justify-center items-center gap-5 mt-2">
            <img src="{{$sc->profile==""?asset('storage/default.jpg'):asset("storage/athlete/$sc->profile") }}" alt="Profile Picture" class="object-cover w-[60px] h-[60px] rounded-full">
            <div class="">
                <flux:heading size="lg">{{ \Illuminate\Support\Str::limit($sc->first_name . ' ' . $sc->last_name, 20) }} ({{\Carbon\Carbon::parse($sc->dob)->year }})</flux:heading>
                <flux:text class="truncate w-[200px]">{{ $sc->email }}</flux:text>
            </div>
            <flux:button wire:click="recruitAthlete({{ $sc->id }})" class="mt-5">Recruit</flux:button>
        </div>
        @endforeach
         @if($athleteSearch->count()>1)
                <div class="mt-4 text-sm text-gray-500 italic">
                    dan lainnya...
                </div>
            @endif
        @endif

    </div>

</flux:modal>
</div>
