<div>
@if (Str::contains(url()->previous(), '/club'))
    <a href="javascript:history.back()" class="flex items-center text-blue-600 hover:underline mb-4">
        <flux:icon.chevron-left class="w-5 h-5 mr-1" />
        Kembali
    </a>
@endif
<livewire:athlete.modal-athlete />
@if (session()->has('message'))
    <flux:callout icon="sparkles" color="green">
        <flux:callout.heading>Alert</flux:callout.heading>
        <flux:callout.text>
            {{ session('message') }}
        </flux:callout.text>
    </flux:callout>
@endif
<div class="grid grid-cols-4 gap-4">
    <div class="col-span-4 md:col-span-1 justify-self-center">
        <div class="flex h-full w-full flex-col gap-4 rounded-xl justify-center items-center">
            <div class="image relative">
             @if ($photo)
    <img src="{{ $photo->temporaryUrl() }}"
         class="rounded-full w-[250px] h-[250px] object-cover">
@else
    <img src="{{ $athlete->photo == ''
        ? asset('storage/default.jpg')
        : asset('storage/athlete/' . $athlete->photo) }}"
        class="rounded-full w-[250px] h-[250px] object-cover">
@endif
                <svg x-on:click="document.getElementById('pot2').click()" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 28 25" stroke-width="1.5" stroke="#333"
                    class="bg-white rounded p-1 size-10 rounded-full absolute right-5 bottom-4  text-gray-500 hover:text-gray-700 cursor-pointer">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                </svg>
            </div>

            <div class="flex flex-col items-center">
                <flux:heading size="lg">{{ $athlete->first_name . ' ' . $athlete->last_name }}</flux:heading>
                <flux:text class="">
                    <p>{{ $athlete->email }}</p>
                </flux:text>
            </div>
            <flux:text class="mt-2 mb-4">
                <p>{{ $athlete->address }}</p>
            </flux:text>
            <flux:button icon="plus-circle" wire:click="edit({{ $athlete->id }})" class="w-full">Edit Profile
            </flux:button>
        </div>
    </div>
    {{-- BODY --}}
    <div class="col-span-4 md:col-span-3 ">
        <flux:navbar class="mb-5">
            @foreach ($navigations as $nav)
                @if ($nav['no'] == $navActive)
                    <flux:navbar.item wire:click="show({{ $nav['no'] }})" current>{{ $nav['name'] }}</flux:navbar.item>
                @else
                    <flux:navbar.item wire:click="show({{ $nav['no'] }})">{{ $nav['name'] }}</flux:navbar.item>
                @endif
            @endforeach
        </flux:navbar>

        @if ($formShow == 1)
            <div class="grid grid-cols-2 ">
                <div class="left-area flex flex-col gap-5">
                    <div class="heading-subheading">
                        <flux:heading>First Name</flux:heading>
                        <flux:text class="">{{ $athlete->first_name }}</flux:text>
                    </div>
                    <div class="heading-subheading">
                        <flux:heading>Last Name</flux:heading>
                        <flux:text class="">{{ $athlete->last_name }}</flux:text>
                    </div>
                    <div class="heading-subheading">
                        <flux:heading>Sex</flux:heading>
                        <flux:text class="">{{ $athlete->gender }}</flux:text>
                    </div>
                    <div class="heading-subheading">
                        <flux:heading>Date Of Birth</flux:heading>
                        <flux:text class="">{{ $athlete->dob }}</flux:text>
                    </div>
                </div>
                <div class="right-area flex flex-col gap-5">
                    <div class="heading-subheading">
                        <flux:heading>NIK/NISD</flux:heading>
                        <flux:text class="">{{ $athlete->identity_number }}</flux:text>
                    </div>
                    <div class="heading-subheading">
                        <flux:heading>Nation</flux:heading>
                        <flux:text class="">{{ $athlete->nation }}</flux:text>
                    </div>
                    <div class="heading-subheading">
                        <flux:heading>City</flux:heading>
                        <flux:text class="">{{ $athlete->city }}</flux:text>
                    </div>
                    <div class="heading-subheading">
                        <flux:heading>Province</flux:heading>
                        <flux:text class="">{{ $athlete->province }}</flux:text>
                    </div>
                    <div class="heading-subheading">
                        <flux:heading>Adress</flux:heading>
                        <flux:text class="">{{ $athlete->address }}</flux:text>
                    </div>
                </div>
            </div>
      @elseif($formShow == 6)
        <div class="w-full flex justify-end">


            </div>
            <div class="grid ">
                <div class="left-area flex flex-col gap-5">
                    <div class="heading-subheading">
                        <table id="athletes"
                            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">#</th>
                                    <th scope="col" class="px-6 py-3">Kompetisi</th>
                                    <th scope="col" class="px-6 py-3">Acara</th>
                                    <th scope="col" class="px-6 py-3">Group Age</th>
                                    <th scope="col" class="px-6 py-3">Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($athlete->historyTime as $history)
                                    <tr
                                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                                            {{ $loop->iteration }}</td>
                                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $history->match->Heat->event->name}}</td>
                                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $history->match->Heat->branch->eventNumber->category->description}}</td>
                                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $history->match->Heat->branch->age->showName() }}</td>
                                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $history->end_time}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
      @elseif($formShow == 5)
    <div class="mt-6">
        <h2 class="text-xl font-semibold mb-4">Daftar Permintaan Pindah Klub</h2>
        <table class="w-full table-auto border border-gray-300 rounded">
            <thead >
                <tr>
                    <th class="p-2 border">Atlet</th>
                    <th class="p-2 border">Klub Lama</th>
                    <th class="p-2 border">Klub Baru</th>
                    <th class="p-2 border">Tanggal Request</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($migrationRequests as $request)
                    <tr class="text-center">
                        <td class="p-2 border">{{ $request->athlete->name() ?? '-' }}</td>
                        <td class="p-2 border">{{ $request->oldClub->name ?? '-' }}</td>
                        <td class="p-2 border">{{ $request->newClub ->name?? '-' }}</td>
                        <td class="p-2 border">{{ \Carbon\Carbon::parse($request->date_request)->format('d-m-Y') }}</td>
                        <td class="p-2 border">
                            @if ($request->status == 1)
                                <span class="text-yellow-500 font-semibold">Pending</span>
                            @elseif ($request->status == 2)
                                <span class="text-green-600 font-semibold">Disetujui</span>
                            @elseif ($request->status == 0)
                                <span class="text-red-500 font-semibold">Ditolak</span>
                            @endif
                        </td>
                        <td class="p-2 border">
                            <button wire:click="lihatDetail({{ $request->id }})" class="text-blue-500 hover:underline">Detail</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center p-4 text-gray-500">Belum ada permintaan pindah klub.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
        @elseif($formShow == 4)
            <div class="w-full flex justify-end">
                <flux:button icon="plus-circle" wire:navigate href="/guardian/{{ $athlete->id }}/add">Add Guardian
                </flux:button>

            </div>
            <div class="grid ">
                <div class="left-area flex flex-col gap-5">
                    <div class="heading-subheading">
                        <table id="athletes"
                            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">#</th>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">Relationship</th>
                                    <th scope="col" class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($parents as $parent)
                                    <tr
                                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                                            {{ $loop->iteration }}</td>
                                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $parent->name }}</td>
                                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $parent->relation }}
                                        </td>
                                        <td class="px-6 py-2">
                                            <flux:button
                                                class="text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800"
                                                type="button" variant="primary" id="ini"
                                                href="/guardian/{{ $parent->id }}/edit">Edit</flux:button>
                                            <flux:button
                                                class="text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800"
                                                type="button" variant="primary" id="ini"
                                                wire:click="detailGuardian({{ $parent->id }})">Detail</flux:button>
                                            <flux:modal.trigger name="delete-profile">
                                                <flux:button variant="danger"
                                                    wire:click="delete({{ $parent->id }})">Delete</flux:button>
                                            </flux:modal.trigger>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        @elseif($formShow == 3)
            <div class="grid grid-cols-1 ">
                <table id="athletes"
                    class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">#</th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                  @foreach ($athlete->clubs->sortByDesc('created_at') as $ac)
                            <tr
                                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <td class="px-6 py-3">{{ $loop->iteration }}</td>
                                <td class="px-6 py-3">{{ $ac->club->name }}</td>

                                <td class="px-6 py-3">
                                    @if ($ac->status!=0)
                                    <flux:badge color="red" icon="arrows-right-left"
                                    class="text-sm cursor-pointer active:scale-[0.9]"
                                    wire:click="migrationRequest('{{ $ac->id }}')">
                                    migrasi
                                </flux:badge>
                                @endif
                                <flux:badge color="blue" icon="information-circle" class="cursor-pointer active:scale-[0.9]"
                                wire:click="DetailClub({{ $ac->club_id }})">detial</flux:badge>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @elseif($formShow == 2)
            <div class="grid grid-cols-2 ">
                <div class="left-area flex flex-col gap-5">
                    <div class="heading-subheading">
                        <flux:heading>Email</flux:heading>
                        <flux:text class="">{{ $athlete->email }}</flux:text>
                    </div>
                    <div class="heading-subheading">
                        <flux:heading>Phone Number</flux:heading>
                        <flux:text class="">{{ $athlete->phone }}</flux:text>
                    </div>
                </div>
                <div class="right-area flex flex-col gap-5">
                    <div class="heading-subheading">
                    </div>

                </div>
            </div>

        @endif

        <div wire:loading style="z-index: 1000">

            <div class="absolute right-0 left-0 bottom-0 top-0  flex justify-center items-center">

                <x-loader />
            </div>
        </div>

        <flux:modal name="edit-profile" class="min-w-[22rem]">
            <div class="space-y-6 flex justify-center items-center w-full
            flex-col">
                <form wire:submit="updateUserProfile" class="flex flex-col justify-center items-center">
                    @if ($photoPreview)
                        <img src="{{ $photoPreview->temporaryUrl() }}" alt=""
                            class="rounded-full w-[250px] h-[250px] object-cover">
                    @endif
                    <input type="file" id="pot2" wire:model="photoPreview">


                    <div class="flex gap-2">
                        <flux:spacer />


                        <flux:button x-on:click="document.getElementById('pot2').click()" class="mt-5">Ubah
                        </flux:button>
                        <flux:button type="submit" class="mt-5">Upload File</flux:button>
                </form>

            </div>
    </div>
    </flux:modal>
    <flux:modal name="detail-profile" class="min-w-[22rem]">
        <div class="flex text-center justify-center items-center">
            <flux:heading>Guardian Detail</flux:heading>
        </div>
        <div class="preview-label mb-5">
            <flux:heading>Guardian Name</flux:heading>
            <flux:text>{{ $name == '' ? 'Not Filled' : $name }}</flux:text>
            <flux:error name="name" />
        </div>
        <div class="preview-label mb-5">
            <flux:heading>Relation</flux:heading>
            <flux:text>{{ $relation == '' ? 'Not Filled' : $relation }}</flux:text>
            <flux:error name="relation" />
        </div>
        <div class="preview-label mb-5">
            <flux:heading>Gender</flux:heading>
            <flux:text>{{ $gender == '' ? 'Not Filled' : ucfirst($gender) }}</flux:text>
            <flux:error name="gender" />
        </div>
        <div class="preview-label mb-5">
            <flux:heading>Email</flux:heading>
            <flux:text>{{ $email == '' ? 'Not Filled' : $email }}</flux:text>
            <flux:error name="email" />
        </div>
        <div class="preview-label mb-5">
            <flux:heading>Phone</flux:heading>
            <flux:text>{{ $phone == '' ? 'Not Filled' : $phone }}</flux:text>
            <flux:error name="phone" />
        </div>
        <div class="preview-label mb-5">
            <flux:heading>Address</flux:heading>
            <flux:text>{{ $address == '' ? 'Not Filled' : $address }}</flux:text>
            <flux:error name="address" />
        </div>

    </flux:modal>

    <flux:modal name="modal-club" class="min-w-[28rem]">
        <div class="flex text-center justify-center items-center mb-4">
            <flux:heading>{{ $this->modalClub['title'] }}</flux:heading>
        </div>
        @if ($this->modalClub['type'] == 1)
        @foreach ($modalDetail as $dItem)

        <div class="preview-label my-2">
            <flux:heading>{{$dItem['title']}}</flux:heading>
            <flux:text class="mt-2">{{$dItem['value']??'Not Filled' }}</flux:text>
            <flux:error name="address" />
        </div>
        @endforeach

        @else
        <form wire:submit="submitMigrationRequest">

        <div class="mb-4">
                <flux:select label="Klub Sekarang" wire:model="old_club" class="w-full border border-gray-300 rounded p-2">
                     <flux:select.option value="{{ $clubDetail->id }}">{{ $clubDetail->name }}</flux:select.option>
                </flux:select>
                <flux:error name="old_club" />
            </div>
                    <div class="mb-4 w-full flex items-center gap-4">
                    <div class="flex-grow">
                        <flux:select
                        label="Klub Tujuan"
                        wire:model="new_club"
                        class="w-full border border-gray-300 rounded p-2"
                        >
                        <flux:select.option value="{{ $new_club_id }}">{{ $new_club }}</flux:select.option>
                        </flux:select>
                    </div>

                    <flux:button
                        wire:click="searchClub"
                        icon="magnifying-glass"
                        class="w-12 h-12 mt-5"
                    />
                    </div>

            <div class="mb-4">
                <flux:heading>Alasan Migrasi</flux:heading>
                <flux:textarea wire:model.defer="reason" rows="4" class="w-full border border-gray-300 rounded p-2"
                    placeholder="Tulis alasan perpindahan klub..."></flux:textarea>
                <flux:error name="reason" />
            </div>

            <div class="flex justify-end gap-2 mt-4">

                <flux:button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Kirim Permintaan
                </flux:button>
            </div>
        </form>
        @endif
    </flux:modal>
     <flux:modal name="modal-search" class="min-w-[22rem]">
    <div class="flex flex-col justify-between items-center mt-5 mt-2">
        <flux:header>Search club</flux:header>
        <div class="flex justify-between items-center mt-5 mt-2">
            <flux:input wire:model.live.debounce.500ms="keyword" placeholder="club Name" />
        </div>

   @if ($clubs)
<div class="flex flex-col mt-2 w-full">
    @foreach ($clubsByKeyword as $c)
    <flux:badge
        color="zinc"
        class="cursor-pointer w-full my-1
               bg-gray-200 text-gray-800 rounded-lg px-4 py-2
               hover:bg-blue-500 hover:text-white
               transition duration-300 ease-in-out"
        wire:click="selectOption('{{ $c->id }}','{{ $c->name }}')"
    >
        {{ $c->name }}
    </flux:badge>
    @endforeach
</div>
@endif

    </div>
</flux:modal>
</div>
</div>
