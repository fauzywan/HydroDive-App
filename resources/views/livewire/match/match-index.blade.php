<div>
     @if (session()->has('message'))
    <x-message-alert></x-message-alert>
    @endif
    <div class="flex justify-start mb-4">
    <a wire:click="backToLeft">
        <flux:button color="gray" class="shadow">
            ← Kembali
        </flux:button>
    </a>
</div>
<div class="flex justify-between items-center">
    <div></div>

    <x-navbar-items :items="$navigations" :active="$navActive" />

    <div></div>
</div>
    @if ($page=="list")
     <table id="athletes" class="w-full text-sm mt-5 text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">nama</th>
                    <th scope="col" class="px-6 py-3">Heat</th>
                    <th scope="col" class="px-6 py-3">Tanggal</th>
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
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $match->heat }}</td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ date("d-F-Y H:i",strtotime($match->start_time)) }}</td>

                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                                    <span class="{{ $match->status ? 'text-green-500' : 'text-red-500' }}">
                                        {{ $match->status ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>
                                    <flux:badge wire:click="deleteMatch('{{ $match->id }}')" color="red">delete</flux:badge>
                                </td>
                            </tr>
                        @endforeach

            </tbody>
        </table>
    @else

      <table id="athletes" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">nama</th>
                    <th scope="col" class="px-6 py-3">Club</th>
                    <th scope="col" class="px-6 py-3">Time</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                    @php $no = 1; @endphp

                    @foreach ($heat->players as $player)
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $no++ }}</td>
                            <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $player->administration->athlete->name() }}</td>
                            <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $player->administration->club->name }}</td>
                            <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $player->end_time }}</td>
                            <td>
                                <flux:badge wire:click="deletePlayer('{{ $player->id }}')" color="red">delete</flux:badge>
                            </td>
                        </tr>
                    @endforeach

                    @foreach ($athletes as $aplayer)
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $no++ }}</td>
                            <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $aplayer->athlete->name() }}</td>
                            <td class="px-6 py-2 text-gray-600 dark:text-gray-300">-</td>
                            <td class="px-6 py-2 text-gray-600 dark:text-gray-300">-</td>
                        <td>
                        <flux:badge
                            class="active:scale-[0.9] cursor-pointer"
                            wire:loading.class="opacity-50 pointer-events-none"
                            wire:loading.class.remove="cursor-pointer"
                            wire:click="startStopWatch('{{ $aplayer->athlete->id }}')"
                            wire:loading.attr="disabled"
                            wire:target="startStopWatch"
                            color="blue"
                        >
                        Mulai
                    </flux:badge>
                            </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
    @endif

    </div>
