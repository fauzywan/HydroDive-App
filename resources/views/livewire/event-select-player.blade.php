<div class="space-y-4">
    @if (session()->has('message'))
        <x-message-alert></x-message-alert>
    @endif

    <!-- Tombol Kembali -->
    <button wire:click="goBack" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">
        ← Kembali ke Event
    </button>

    <!-- Informasi Event dan Heat -->
    <div class="bg-white dark:bg-gray-800 rounded p-4 shadow">
        <h3 class="text-lg font-semibold mb-2">Informasi Event</h3>
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium mb-1">Nomor Event</label>
                <input type="text" class="w-full border rounded px-3 py-2 bg-gray-100 dark:bg-gray-700"
                       value="{{ $eventName ?? 'Tidak ada data' }}" readonly>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium mb-1">Sesi</label>
                <input type="number" class="w-full border rounded px-3 py-2 bg-gray-100 dark:bg-gray-700"
                       value="{{ $heatName ?? 'Tidak ada data' }}" >
            </div>
        </div>
    </div>

    <!-- Select & Tombol Add -->
    <div class="flex items-center gap-2">
        <flux:select wire:model="selectedAthlete" class="w-full">
            <option value="">Pilih Atlet</option>
            @foreach ($availableAthletes as $athlete)
                <option value="{{ $athlete['id'] }}">{{ $athlete['athlete']->first_name }}</option>
            @endforeach
        </flux:select>

        <flux:button wire:click="addAthleteToEvent" class="px-4 py-2 cursor-pointer bg-green-500 hover:bg-green-600 text-white rounded">
           Add
        </flux:button>
    </div>


    <!-- Daftar Atlet yang Ditambahkan -->
    <div class="bg-gray-100 dark:bg-gray-800 rounded p-4 shadow">
        <h3 class="text-lg font-semibold mb-2">Atlet yang Ditambahkan (Posisi Line):</h3>
        <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">Anda sedang dalam mode update. Silakan tambahkan atau hapus atlet.</p>



        @if (count($eventAthletes) > 0)
            <ul class="space-y-2">
                @foreach ($eventAthletes as $index => $data)
                    <li class="flex items-center justify-between bg-white dark:bg-gray-700 px-4 py-2 rounded shadow gap-4">
                        <span>{{ $data['athlete']->first_name }}</span>

                        <input type="number" min="1" class="w-20 px-2 py-1 border rounded"
                               wire:model.lazy="eventAthletes.{{ $index }}.lane"
                               placeholder="Lane">
                    @if ($mode!='update')

                    <button wire:click="removeAthlete({{ $index }})"
                    class="px-2 py-1 text-white bg-red-500 hover:underline text-sm">Hapus</button>

                    @endif
                </li>
                @endforeach
            </ul>
        @else
            <p class="text-sm text-gray-600 dark:text-gray-300">Belum ada atlet yang ditambahkan.</p>
        @endif
    </div>

    <!-- Tombol Simpan -->
    <div class="text-right">
        <flux:button wire:click="saveAthletes" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded">
            Simpan
        </flux:button>
    </div>

</div>
