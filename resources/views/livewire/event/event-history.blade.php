<div>
     @if (session()->has('message'))
        <x-message-alert></x-message-alert>
    @endif

        <div class="flex justify-between mb-4">
         <div class="">
            <flux:heading size="lg">
                Riwayat Event
            </flux:heading>
        </div>
            <div>
                <flux:select wire:model.live="yearSelect" class="px-2 py-2">
                    @foreach ($eventYears as $year)
                    <flux:select.option value="{{ $year }}">{{ $year }}</flux:select.option>
                    @endforeach
                </flux:select>
        </div>
    </div>


    <div class="flex justify-between items-center mb-5 w-full"></div>
    <div class="overflow-x-auto mt-5 relative">
        <table id="athletes" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Nama</th>
                    <th scope="col" class="px-6 py-3">Penyelenggara</th>
                    <th scope="col" class="px-6 py-3">Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($events as $event)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                            {{  $loop->iteration }}
                        </td>
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                            {{ $event->name}}
                        </td>
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                            {{ $event->club_id==1?"Federasi":$event->club->name}}
                        </td>
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                           <flux:badge class="active:scale-[0.9] text-bold cursor-pointer"
                            color="blue"
                           wire:click="detailHistory({{ $event->id }})">
                                detail
                            </flux:badge>
                        </td>


                    </tr>
                @endforeach
            </tbody>
        </table>

        <div wire:loading>
            <div class="w-full flex justify-center items-center absolute top-0 left-0 right-0 bottom-0 z-50">
                <flux:icon.loading />
            </div>
        </div>
    </div>
    @if(count($events)>0)
            <div class="text-center mt-5">
                <p class="text-gray-500">Tidak ada event yang ditemukan.</p>
            </div>

        @endif
    </div>
