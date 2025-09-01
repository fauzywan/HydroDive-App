<div>
    <div class="flex justify-between items-center mb-6">

        <flux:button type="button" icon="arrow-left" href="/swimming-category" wire:navigate>
            Kembali
        </flux:button>
        <p>Leaderboard {{ $category->description }}</p>
        <flux:button type="button" icon="information-circle" wire:click="openModal('info-modal')">
            Info
        </flux:button>
    </div>
    <div class="flex w-full mt-2 gap-2">
        <flux:input wire:model.debounce.500ms="search" icon="magnifying-glass" placeholder="Search athlete..."/>
    </div>

    <div class="overflow-x-auto mt-5 relative">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3">Rank</th>
                    <th class="px-6 py-3">Athlete</th>
                    <th class="px-6 py-3">Club</th>
                    <th class="px-6 py-3">Event</th>
                    <th class="px-6 py-3">Pertandingan</th>
                    <th class="px-6 py-3">Duration</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leaderboards as $index => $item)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                            {{ $leaderboards->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-2">{{ $item->athlete?->first_name." ".$item->athlete?->lastName }}</td>
                        <td class="px-6 py-2">{{ $item->club?->name ?? '-' }}</td>
                        <td class="px-6 py-2">{{ $item->event?->name ?? '-' }}</td>
                        <td class="px-6 py-2">{{ $item->player?->match->name ?? '-' }}</td>
                        <td class="px-6 py-2">{{ $item->duration ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-5">
            {{ $leaderboards->links() }}
        </div>
    </div>
<flux:modal name="info-modal" class="w-full max-w-lg">
    <div class="p-6">
        <h2 class="text-lg font-bold mb-4">Informasi Leaderboard</h2>
        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
            Halaman ini menampilkan hasil perlombaan berdasarkan kategori yang dipilih.
            Peringkat atlet ditentukan dari catatan waktu tercepat yang tercatat pada pertandingan.
            <br><br>
            Melalui halaman ini, Anda dapat:
        </p>
        <ul class="list-disc pl-6 mt-3 text-gray-600 dark:text-gray-300">
            <li>Melihat peringkat atlet berdasarkan hasil pertandingan.</li>
            <li>Meninjau detail atlet, klub, kategori, dan event yang diikuti.</li>
            <li>Membandingkan catatan waktu antar peserta.</li>
        </ul>
        <div class="mt-6 flex justify-end">
            <flux:button wire:click="closeModal('info-modal')">Tutup</flux:button>
        </div>
    </div>
</flux:modal>
</div>
