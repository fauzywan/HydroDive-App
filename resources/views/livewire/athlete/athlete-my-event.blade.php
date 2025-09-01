<div class="overflow-x-auto mt-6 relative shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th class="px-6 py-3">#</th>
                <th class="px-6 py-3">Nama Event</th>
                <th class="px-6 py-3">Cabang</th>
                <th class="px-6 py-3">Rentang Usia</th>
                <th class="px-6 py-3">Dimulai</th>
                <th class="px-6 py-3">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($eventAdministrations as $event)
                <tr class="border-b dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                    <td class="px-6 py-3 text-gray-900 dark:text-white">{{ $loop->iteration }}</td>
                    <td class="px-6 py-3">{{ $event->event->name ?? '-' }}</td>
                    <td class="px-6 py-3">{{ $event->branch->name }}</td> {{-- Ganti jika ada relasi nama cabang --}}
                    <td class="px-6 py-3">{{ $event->branch->groupAge() }}</td> {{-- Ganti jika ada relasi nama cabang --}}
                    <td class="px-6 py-3 font-semibold text-gray-700 dark:text-gray-300">
                       {{$event->competition_start}}
                    <td class="px-6 py-3">
                        @if ($event->status_fee)
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100">
                                Lunas
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100">
                                Belum Lunas
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-center">

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center italic text-gray-500">
                        Tidak ada event yang diikuti.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
