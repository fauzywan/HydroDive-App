<div class="space-y-4">
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

    <!-- Daftar Atlet yang Ditambahkan -->
    <div class="bg-gray-100 dark:bg-gray-800 rounded p-4 shadow">
        <h3 class="text-lg font-semibold mb-2">Atlet yang Ditambahkan:</h3>
        <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">{{ $navActiveDesc }}</p>



        @if (count($mathces) > 0)
  <table id="athletes" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Event</th>
                    <th scope="col" class="px-6 py-3">Pertandingan</th>
                    <th scope="col" class="px-6 py-3">Ranking</th>
                    <th scope="col" class="px-6 py-3">Perolehan Waktu</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($mathces as $match)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                            {{  $loop->iteration }}
                        </td>
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                            {{  $match['event_name'] }}
                        </td>
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                            {{  $match['match_name'] }}
                        </td>
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                            {{  $match['rank'] }}
                        </td>
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                            {{  $match['time'] }}
                        </td>


                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <p class="text-sm text-gray-600 dark:text-gray-300">Belum ada atlet yang ditambahkan.</p>
        @endif
    </div>


</div>
