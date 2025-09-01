<div >
    <button wire:click="goBack" class="mt-4 px-4 py-2 mb-2 bg-blue-500 hover:bg-blue-600 text-white rounded">
        ← Kembali ke Event
    </button>
        @if (session()->has('message'))
        <x-message-alert></x-message-alert>
    @endif
    <h1 class="text-2xl font-bold mb-4">Match Play Menu</h1>
    <!-- Navigation Tabs -->
    <div class="flex space-x-4 mb-6 justify-between">
        <div class="flex gap-2">

            @foreach ($navigations as $nav)
            <button
            wire:click="show({{ $nav['no'] }})"
            class="px-4 py-2 rounded
            {{ $navActive === $nav['no'] ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100' }}">
            {{ $nav['name'] }}
            </button>
            @endforeach
            <button
                wire:click="finish"
                class="px-4 py-2 rounded cursor-pointer
                bg-blue-600 text-white">
                Selesaikan Pertandingan
            </button>
        </div>
        <div class="flex">
    <flux:button
        icon="plus-circle"
        wire:click="addAthlete"
        class="px-4 py-2 rounded cursor-pointer
        bg-blue-600 text-white">
        Tambah Peserta
    </flux:button>

</div>
    </div>

    <!-- Content Area -->
    <div>
        @if ($navActive === 1)
            <!-- User List -->
            <h2 class="text-xl font-semibold mb-4">Peserta</h2>
            <div wire:poll.5s="loadData">
            <table class="min-w-full text-left border border-gray-300 dark:border-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-800">
                    <tr>
                        <th class="px-4 py-2 border">Lintasan</th>
                        <th class="px-4 py-2 border">Nama</th>
                        <th class="px-4 py-2 border">Waktu</th>
                        <th class="px-4 py-2 border">action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($player as $p)
                        <tr class="border-t dark:border-gray-600">
                            <td class="px-4 py-2 border">{{ $p['line']}}</td>
                            <td class="px-4 py-2 border">{{ $p['name']}}</td>
                            <td class="px-4 py-2 border">{{ $p['time']}}</td>
                            <td class="px-4 py-2 border">
                                {{-- <flux:button wire:click="pushToApi('{{ $p['line'] }}')">Test</flux:button> --}}
                                @if ($p['time'] != null)
                                    <flux:button wire:click="ResetData('{{ $p['id'] }}')">Reset</flux:button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @elseif ($navActive === 2)
          <h2 class="text-xl font-semibold mb-4">Detail Event</h2>
    <div class="space-y-2">
        <p><strong>Nomor Acara</strong> {{ $heat->eventName(); }}</p>
        <p><strong> Event:</strong> {{ $eventDetail->name }}</p>
        <p><strong>Lokasi:</strong> {{ $eventDetail->location }}</p>
        <p><strong>Waktu Mulai Event:</strong> {{ $eventDetail->competition_start }}</p>
        <p><strong>Waktu Selesai Event:</strong> {{ $eventDetail->competition_end }}</p>
        <p><strong>Deskripsi:</strong> {{ $eventDetail->description }}</p>
    </div>
        @endif
    </div>
    <flux:modal name="finish-modal" class="min-w-[22rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Delete Athlete?</flux:heading>

            <flux:text class="mt-2">
                <p>Selesaikan Pertandingan ini</b> Pastikan Data Telah sesuai</p>
            </flux:text>
        </div>
        <div class="flex gap-2">
            <flux:spacer />
            <flux:modal.close>
                <flux:button variant="ghost">Cancel</flux:button>
            </flux:modal.close>

            <flux:button type="button" wire:click="finishEvent" variant="danger">Ya, Lanjut</flux:button>
        </div>
    </div>

</flux:modal>
</div>
