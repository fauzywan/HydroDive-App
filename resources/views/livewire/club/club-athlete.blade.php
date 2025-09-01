<div>

    @if (session()->has('message'))

    <flux:callout icon="sparkles" color="green">
        <flux:callout.heading>Alert</flux:callout.heading>
        <flux:callout.text>
            {{ session('message') }}
        </flux:callout.text>
    </flux:callout>
    @endif
<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Statistik Ringkas -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <!-- Jumlah Atlet -->
            <div class="rounded-xl border border-gray-200 p-4 shadow-sm bg-white dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Jumlah Atlet Aktif</h2>
                <div class="text-2xl font-bold text-blue-600">
                    {{ $athletes->where('status',1)->count() }}
                </div>
            </div>

            <!-- Jumlah Pelatih -->
            <div class="rounded-xl border border-gray-200 p-4 shadow-sm bg-white dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Jumlah Jumlah Atlet nonAktif</h2>
                <div class="text-2xl font-bold text-green-600">
                    {{ $athletes->where('status',0)->count() }}
                </div>
            </div>

            <!-- Total Kompetisi -->
            <div class="rounded-xl border border-gray-200 p-4 shadow-sm bg-white dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Total</h2>
                <div class="text-2xl font-bold text-yellow-600">
                    {{ $athletes->count() }}
                </div>
            </div>
        </div>

    <div class="flex w-full">

        <div class="w-full flex justify-end">

            <flux:dropdown>
                <flux:button icon:trailing="chevron-down">Add Athlete</flux:button>
                <flux:menu>
                    <flux:menu.item icon="plus" href="/athlete/add" wire:navigate>New Athlete</flux:menu.item>
                    <flux:menu.separator />
                    <flux:menu.item icon="plus-circle" class="cursor-pointer" wire:click="recruitAthlete">Recruit</flux:menu.item>
                </flux:menu>
            </flux:dropdown>



        </div>
    </div>
    <div class="mt-5 grid-cols-4 grid">
        <div class="col-span-3">


        </div>
        <div class="col-span-1">


        </div>

    </div>
    <div class="flex flex-col justify-center items-center">
      <flux:navbar class="mb-5">
            @foreach ($navigations as $nav)
                @if ($nav['no'] == $navActive)
                    <flux:navbar.item wire:click="show({{ $nav['no'] }})" current>{{ $nav['name'] }}</flux:navbar.item>
                @else
                    <flux:navbar.item wire:click="show({{ $nav['no'] }})">{{ $nav['name'] }}</flux:navbar.item>
                @endif
            @endforeach
        </flux:navbar>

    </div>

    @if($formShow==1)
    <div class="overflow-x-auto mt-5 relative">
        <table id="athletes" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Gender</th>
                    <th scope="col" class="px-6 py-3">Kota</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($athletes as $athlete)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $athlete->first_name." ". $athlete->lastName }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $athlete->gender }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $athlete->city }}</td>

                        <td class="px-6 py-2">
                            <flux:button class="text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800" type="button" variant="primary" id="ini" href="/athlete/{{$athlete->id}}/profile">Detail</flux:button>
                            <flux:button class="text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800" type="button" variant="primary" id="ini" wire:click="nonaktifAthlete({{ $athlete->id }})">nonaktifkan</flux:button>
                            <flux:modal.trigger name="delete-profile">
                                <flux:button variant="danger" wire:click="delete({{ $athlete->id }})">Delete</flux:button>
                            </flux:modal.trigger>
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

    @elseif($formShow==3)
    <form wire:submit="setRegistrationFee" class="flex justify-center items-center">
        <flux:field>
            <flux:label>Registration Fee</flux:label>
            <flux:description>Biaya Pendaftaran Untuk Setiap Atlet yang mendaftar</flux:description>
            <flux:input wire:model="nominal"/>
            <flux:error name="nominal" />
        </flux:field>
        <flux:button type="submit">Save</flux:button>
    </form>
    @else
    <div class="overflow-x-auto mt-5 relative">
        <table id="athletes" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
           <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
               <tr>
                   <th scope="col" class="px-6 py-3">#</th>
                   <th scope="col" class="px-6 py-3">Nama</th>
                   <th scope="col" class="px-6 py-3">Gender</th>
                   <th scope="col" class="px-6 py-3">Kota</th>
                   <th scope="col" class="px-6 py-3">Status</th>

                   <th scope="col" class="px-6 py-3">Actions</th>
               </tr>
           </thead>
           <tbody>
               @foreach ($AthleteWaitingList as $athlete)
                   <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                       <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}</td>
                       <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $athlete->first_name." ". $athlete->lastName }}</td>
                       <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $athlete->gender }}</td>
                       <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $athlete->city }}</td>
                        <td>
                        @if($athlete->fee->where('club_id', $club->id)->count()>0)

                            @if($athlete->fee->where('club_id', $club->id)->first()->paid==0)
                            <flux:badge color="green">Administrasi Belum Selesai</flux:badge>
                            @else
                            <flux:badge color="red">Non aktif</flux:badge>
                            @endif
                            @else

                            <flux:badge color="red">Non aktif</flux:badge>
                @endif
                        </td>
                       <td class="px-6 py-2">
                           <flux:button class="text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800" type="button" variant="primary" id="ini" href="/athlete/{{$athlete->id}}/profile">Detail</flux:button>
                           <flux:button class="text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800" type="button" variant="primary" id="ini" wire:click="recruitAthlete({{ $athlete->id }})">Active</flux:button>
                           <flux:modal.trigger name="delete-profile">
                               <flux:button variant="danger" wire:click="delete({{ $athlete->id }})">Delete</flux:button>
                           </flux:modal.trigger>
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
    @endif

    {{-- MODAL DELETE --}}


<flux:modal name="modal-fee" class="min-w-[22rem]">
    <div class="space-y-6">
        <div>

            <flux:input label="Registration Fee" placeholder="Your name" wire:model="registration_fee" />

        </div>

        <div class="flex gap-2">
            <flux:spacer />

            <flux:modal.close>
                <flux:button variant="ghost">Cancel</flux:button>
            </flux:modal.close>

            <flux:button type="button" wire:click="addAthleteWithFee" variant="danger">Add Athlete</flux:button>
        </div>
    </div>

</flux:modal>
<flux:modal name="delete-profile" class="min-w-[22rem]">
   <div class="space-y-6">
    <div>
        @if($modalDelete == 1)
            <flux:heading size="lg">Delete Athlete?</flux:heading>
            <flux:text class="mt-2">
                <p>You're about to delete <b>{{ $first_name }}</b></p>
                <p>This action cannot be reversed.</p>
            </flux:text>
        @elseif($modalDelete == 2)
            <flux:heading size="lg">Aktifkan Atlet?</flux:heading>
            <flux:text class="mt-2">
                <p>Apakah Anda yakin ingin mengaktifkan atlet <b>{{ $first_name }}</b>?</p>
                <p>Atlet akan dapat mengikuti kompetisi setelah diaktifkan.</p>
            </flux:text>
        @elseif($modalDelete == 3)
            <flux:heading size="lg">Nonaktif Atlet?</flux:heading>
            <flux:text class="mt-2">
                <p>Apakah Anda yakin ingin mengnonaktif atlet <b>{{ $first_name }}</b>?</p>
                <p>Atlet akan dapat mengikuti kompetisi setelah dinonaktif.</p>
            </flux:text>
        @endif
    </div>

    <div class="flex gap-2">
        <flux:spacer />

        <flux:modal.close>
            <flux:button variant="ghost">Cancel</flux:button>
        </flux:modal.close>

        @if($modalDelete == 1)
            <flux:button type="button" wire:click="destroy" variant="danger">Delete Athlete</flux:button>
        @elseif($modalDelete == 2)
            <flux:button type="button" wire:click="addAthleteWithFee">Aktifkan</flux:button>
        @elseif($modalDelete == 3)
            <flux:button type="button" wire:click="nonaktifAthleteProcess">Non Aktifkan</flux:button>
        @endif
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

        @forelse ($athleteSearch as $sc)

        <div class="flex justify-center items-center gap-5 mt-2">
            <img src="{{$sc->profile==""?asset('storage/default.jpg'):asset("storage/athlete/$sc->profile") }}" alt="Profile Picture" class="object-cover w-[60px] h-[60px] rounded-full">
            <div class="">
                <flux:heading size="lg">{{ $sc->first_name ." ". $sc->last_name}}</flux:heading>
                <flux:text class="truncate w-[200px]">{{ $sc->email }}</flux:text>
            </div>
            <flux:button wire:click="recruitAthlete({{ $sc->id }})" class="mt-5">Recruit</flux:button>
        </div>

        @empty
        <div class="flex justify-center items-center gap-5 mt-2">
                <i>Tidak ada Atlet yang ditemukan   </i>
        </div>

        @endforelse

        @endif

    </div>

</flux:modal>

</div>
