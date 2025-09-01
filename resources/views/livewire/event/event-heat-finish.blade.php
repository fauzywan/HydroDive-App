<div>
    <h1>Berlangsung: 50 M GAYA PUNGGUNG MEN LCM</h1>
   <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">No</th>
                <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">Nama Pemain</th>
                <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">Heat</th>
                <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">Durasi</th>
                <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">Posisi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($players as $index => $player)
                 <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">

                    <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $index + 1 }}</td>
                    <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $player['athlete_name'] }}</td>
                    <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $player['heat'] }}</td>
                    <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $player['result_time'] ?? '-' }}</td>
                    <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                        <input type="number"
                               wire:model="players.{{ $index }}.position"
                               min="1" style="width: 60px;">
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Tidak ada data pemain.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="flex justify-end">
        <flux:button wire:click="endHeat" class="mt-2 ">Selesaikan Pertandingan</flux:button>
    </div>
</div>
