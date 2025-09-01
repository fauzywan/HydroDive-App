<div>
    @if (session()->has('message'))
        <x-message-alert></x-message-alert>
    @endif



    {{-- NAV --}}
    <div class="flex flex-col justify-center items-center mb-3">
        <flux:navbar>
            @foreach ($navigations as $nav)
                @if ($nav['no'] == $navActive)
                    <flux:navbar.item wire:click="show({{ $nav['no'] }})" current>
                        {{ $nav['name'] }}
                    </flux:navbar.item>
                @else
                    <flux:navbar.item wire:click="show({{ $nav['no'] }})">
                        {{ $nav['name'] }}
                    </flux:navbar.item>
                @endif
            @endforeach
        </flux:navbar>
    </div>
    <div class="w-full flex justify-between items-center mb-3">
        {{-- SEARCH --}}
        <div class="w-3/3 mt-2 mr-2">
            <flux:input
                wire:model.live.debounce.1000ms="keyword"
                icon="magnifying-glass"
                placeholder="Cari Event..."
            />
        </div>

        {{-- BUTTON ADD --}}
        <flux:button icon="plus-circle" href="/event/add" wire:navigate>
            Buat Kompetisi
        </flux:button>
    </div>
    {{-- TABLE --}}

    @if($eventBerlangsung)
    <div class="bg-dark w-full flex justify-between items-center p-3 border-1 border-gray-50 rounded-lg">
        <div class="text">
             Event Berjalan: <span class="text-white">{{ $eventBerlangsung->name}}</span>
        </div>
        <flux:button icon="play" wire:click="GoToActiveEvent('{{ $eventBerlangsung->id }}')" class="text-white cursor-pointer">Masuk </flux:button>
    </div>
    @endif

    <div class="overflow-x-auto mt-5 relative">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Penyelenggara</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Poster</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($events as $event)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-2">{{ $events->firstItem() + $loop->index }}</td>
                        <td class="px-6 py-2">{{ $event->name }}</td>
                        <td class="px-6 py-2">{{ $event->club_id==1 ? "Federasi" : $event->club->name }}</td>
                        <td class="px-6 py-2 cursor-pointer" wire:click="eventActive('{{ $event->id }}')">
                            @if($event->status == 0)
                                <flux:badge color="red" class="text-xs">Nonaktif</flux:badge>
                            @else
                                <flux:badge color="green" class="text-xs">Aktif</flux:badge>
                            @endif
                        </td>
                        <td class="px-6 py-2">
                            <flux:badge wire:click="showPoster('{{ $event->poster }}')">
                                Lihat Poster
                            </flux:badge>
                        </td>
                        <td class="px-6 py-2 flex gap-2">
                            <x-badge-href color="blue" href="/event/{{ $event->id }}/edit">Edit</x-badge-href>
                            <x-badge-href color="green" href="/event/{{ $event->id }}/detail">Detail</x-badge-href>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada event ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- LOADING --}}
        <div wire:loading>
            <div class="absolute inset-0 flex justify-center items-center bg-white/70 dark:bg-gray-900/70">
                <flux:icon.loading />
            </div>
        </div>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-5">
        {{ $events->links() }}
    </div>

    {{-- MODAL POSTER --}}
    <flux:modal name="modal-poster" class="min-w-[22rem]">
        <div class="space-y-6 text-center">
            <flux:heading size="lg">Poster Event</flux:heading>
            @if ($poster)
                <img src="{{ $poster }}" alt="Poster Event" class="mx-auto max-h-96 rounded shadow-md">
            @else
                <p class="text-gray-500 italic">Poster belum tersedia.</p>
            @endif
            <div class="flex justify-center gap-2 mt-4">
                <flux:modal.close>
                    <flux:button variant="ghost">Tutup</flux:button>
                </flux:modal.close>
                @if ($poster)
                    <flux:button>
                        <a href="{{ $poster }}" download>Unduh Poster</a>
                    </flux:button>
                @endif
            </div>
        </div>
    </flux:modal>
</div>
