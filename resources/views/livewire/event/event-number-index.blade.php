<div>
    @if (session()->has('message'))
        <x-message-alert></x-message-alert>
    @endif

    <section class="flex justify-center items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="/club/my-event" navigate:true>Kompetisi Saya</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="/event/{{ $eventNumber->event->id }}/detail"
                navigate:true>{{ $eventNumber->event->name }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="/number/{{ $eventNumber->event->id }}/list"
                navigate:true>{{ $eventNumber->number }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </section>

    <div class="flex justify-between items-center mt-2">
        <div> </div>
        <flux:navbar>
            @foreach ($navigations as $nav)
                @if ($nav['no'] == $navActive)
                    <flux:navbar.item wire:navigate href="{{ $nav['href'] }}" current>{{ $nav['name'] }}
                    </flux:navbar.item>
                @else
                    <flux:navbar.item wire:navigate href="{{ $nav['href'] }}">{{ $nav['name'] }}</flux:navbar.item>
                @endif
            @endforeach
        </flux:navbar>
        <div> </div>
    </div>
    <div class="mb-2"></div>
  <x-played-event-heat :eventBerlangsung="$eventBerlangsung" />
  <div class="mt-2"></div>
    @if ($navActive == 1)
        <div class="flex justify-end mx-2">
            <flux:button icon="plus-circle" href="/event/{{ $eventNumber->id }}/{{ auth()->user()->role_id==1?'branch-admin-add':'branch-add' }}">Group Age</flux:button>
        </div>
        Perlombaan : {{ $eventNumber->category->description }}
        <table id="branch-" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Nama</th>
                    <th scope="col" class="px-6 py-3">Kapasitas</th>
                    <th scope="col" class="px-6 py-3">Babak</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($eventNumber->branches as $branch)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td scope="col" class="px-6 py-3">{{ $loop->iteration }}</td>
                        <td scope="col" class="px-6 py-3">{{ $branch->age->name }} ({{ $branch->groupAge() }})</td>
                        <td scope="col" class="px-6 py-3">{{ $branch->administration->where('status',1)->count() }} /
                            {{ $branch->capacity }}</td>
                        <td scope="col" class="px-6 py-3">
                            <input type="checkbox" wire:click="toggleStatus({{ $branch->id }})"
                                    @if($branch->status) checked @endif>

                        </td>
                        <td scope="col">
                            <flux:badge class="text-xs" color="{{ $branch->is_final ? 'red' : 'green' }}">
                                {{ $branch->is_final ? 'FINAL' : 'PRELIM' }}
                            </flux:badge>
                            {{-- @if ($branch->heats->where('status', 1)->count() > 0 || $branch->heats->where('status', 0)->count() > 0)
                                @if ($branch->heats->where('status', 1)->count() > 0)
                                    <flux:badge class="text-xs" color="green">
                                        {{ $branch->heats->where('status', 1)->first()->name }}
                                    </flux:badge>
                                @elseif($branch->heats->where('status', 0)->count() > 0)
                                    <flux:badge class="text-xs" color="red">
                                        {{ $branch->heats->where('status', 0)->first()->name }}
                                    </flux:badge>
                                @else
                                    <flux:badge class="text-xs" color="red">Belum Dimulai</flux:badge>
                                @endif
                            @endif --}}
                        </td>
                        <td class=" text-gray-600 dark:text-gray-300">
                            @if ($branch->heats->count() == 0)
                                <flux:badge color="yellow" wire:click="prelimSet({{ $branch->id }})"
                                    class="text-xs cursor-pointer hover:bg-gray-300 hover:text-black">Mulai</flux:badge>
                            @endif
                            <flux:badge color="green" wire:navigate href="/branch/{{ $branch->id }}/edit"
                                class="text-xs cursor-pointer hover:bg-gray-300 hover:text-black">Edit</flux:badge>
                        {{-- <x-dropdown-heat :heat={{ $branch->heats->first() }} :branch=$branch :isMatchActive=$matchStatus/> --}}
                            @if ($branch->heats->where('status', 0)->count() > 0)
                                <flux:badge color="red" class="cursor-pointer active scale-[0.9]"
                                    wire:click="StartEventByBranch('{{ $branch->id }}','{{  $branch->administration->where('status',1)->count() }}')">Mulai</flux:badge>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif($navActive == 3)
    <table id="athletes" class="mt-3 w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">nama</th>
                    <th scope="col" class="px-6 py-3">Group Age</th>
                    <th scope="col" class="px-6 py-3">Heat</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                    @php $no = 1; @endphp
                        @foreach ($matches as $match)
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $no++ }}</td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $match->name }}</td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $match->Heat->branch->age->showName() }}</td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $match->heat }}</td>

                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                                    <span class="{{ $match->status ? 'text-green-500' : 'text-red-500' }}">
                                        {{ $match->status ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>
                                    <flux:badge wire:click="detailMatch('{{ $match->id }}')" color="green">detail</flux:badge>
                                    <flux:badge wire:click="deleteMatch('{{ $match->id }}')" color="red">delete</flux:badge>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
    @elseif($navActive == 2)
        @foreach ($eventNumber->branches as $branch)
            Group Age : {{ $branch->age->name }}
            @if ($branch->is_final!=1)

            <div class="flex flex-end justify-end">
                <flux:button  wire:click="prelimSet({{ $branch->id }},2)">Tambah Sesi</flux:button>
            </div>
          @endif
            <table id="branch-" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-4">
                <thead>
                    <tr>
                        <th scope="col" class="px-6 py-3">#</th>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Babak</th>
                        <th scope="col" class="px-6 py-3">Best of</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($branch->heats as $heat)
                        <tr
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <td scope="col" class="px-6 py-3">{{ $loop->iteration }}</td>
                            <td scope="col" class="px-6 py-3"> {{ $heat->name }}</td>
                            <td scope="col" class="px-6 py-3"> {{ $heat->total_heat }} Heat</td>
                            <td scope="col" class="px-6 py-3"> {{ $heat->best_of }}</td>
                            <td scope="col" class="px-6 py-3">
                                @if ($heat->status == 1)
                                    <span class="text-green-600 font-semibold">Aktif</span>
                                @elseif ($heat->status == 2)
                                    <span class="text-yellow-600 font-semibold">Dijeda</span>
                                @elseif ($heat->status == 0)
                                    <span class="text-gray-500 font-semibold">Tidak Aktif</span>
                                @else
                                    <span class="text-red-600 font-semibold">Selesai</span>
                                @endif
                            </td>
                            <td clas>
 <flux:badge color="green" wire:click="detailHeat('{{ $heat->id }}', '{{ $branch->is_final }}')"
                                class="text-xs cursor-pointer hover:bg-gray-300 hover:text-black">detail</flux:badge>
                                @if ($heat->status == 0)

                                <flux:badge color="red" class="cursor-pointer active scale-[0.9]"
                                wire:click="StartEvent('{{ $heat->id }}','{{  $branch->administration->where('status',1)->count() }}')">Mulai</flux:badge>

                                @elseif($heat->status==2)
                                <flux:badge color="red" class="cursor-pointer active scale-[0.9]"
                                wire:click="StartEventBack('{{ $heat->id }}','{{  $branch->administration->where('status',1)->count() }}')">Mulai Kembali</flux:badge>

                                @elseif($heat->status==1)

                                <x-dropdown-heat :heat=$heat :isMatchActive=$matchStatus/>

                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @endif

    <flux:modal name="session-continue" class="min-w-[22rem]">
        <form class="space-y-6" wire:submit="activeBackHeat">

     <flux:select wire:model.live="selectActiveBack" label="Club">
                    @if($selectedHeat!=null)
                        @foreach ($selectedHeat->matches as $m)
                        <flux:select.option  value="{{ $m->id }}">Heat {{$m->heat}}</flux:select.option>
                        @endforeach
                    @endif
                    </flux:select>

            <flux:button type="submit">Pilih</flux:button>
        </form>
    </flux:modal>
    <flux:modal name="select-event" class="min-w-[22rem]">
        <form class="space-y-6" wire:submit="startEventHeatById">

     <flux:select wire:model="heates_id" label="Club">
                    @if($heates!=null)
                        @foreach ($heates as $h)
                        <flux:select.option  value="{{ $h->id }}">{{$h->name}}</flux:select.option>
                        @endforeach
                    @endif
                    </flux:select>

            <flux:button type="submit">Pilih</flux:button>
        </form>
    </flux:modal>
    <flux:modal name="session-branch" class="min-w-[22rem]">
        <form class="space-y-6" wire:submit="addHeat">
            <div>
                <flux:heading size="lg">Pembagian Sesi Renang</flux:heading>
                <flux:input  type="text" wire:model="name_heat" label="Nama Sesi" placeholder="misal:Penyisihan"/>
            </div>
            <flux:input label="Group Age" wire:model="groupSelectedName" />
            <flux:input label="Kapasitas" wire:model="capacity" readonly />
            <div class="flex">
                <flux:input label="Heat" wire:model="total_heat" type="number" />
                <flux:input label="Lintasan" wire:model="total_line" type="number" />
            </div>
            {{-- <div class="flex flex-col space-y-2">
                <label class="text-sm font-medium t">Range</label>
                <small class="text-sm font-xs text-gray-200">Peringkat yang diperebutkan</small>
                <div class="flex space-x-2">
                    <div class="flex flex-col">
                        <flux:input label="mulai" id="from_rank" wire:model="from_rank" type="number" />
                    </div>
                    <div class="flex flex-col">
                        <flux:input label="sampai" id="to_rank" wire:model="to_rank" type="number" />
                    </div>
                </div>
            </div> --}}
                 <flux:input label="Dari Sesi" description="Total Atlit untuk Tahap Selanjutnya" wire:model="best_of"
            type="number" />
            <flux:button type="submit">Simpan</flux:button>
        </form>
    </flux:modal>
</div>
