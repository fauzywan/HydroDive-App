<div class="w-full mx-auto my-4">
    <div class="rounded-2xl shadow-md p-6 bg-white border border-gray-200">
        @if ($event->status == 1)
            <span class="inline-block px-3 py-1 text-sm font-medium text-white bg-green-500 rounded-full mb-2">
                Berlangsung
            </span>
        @else
            <span class="inline-block px-3 py-1 text-sm font-medium text-white bg-red-500 rounded-full mb-2">
                Nonaktif
            </span>
        @endif

        <h2 class="text-xl font-semibold text-gray-800">
            {{ $event->name }}
        </h2>
        <p class="text-gray-500 text-sm mb-4">
            {{ \Carbon\Carbon::parse($event->competition_start)->translatedFormat('d F Y H:i') }} WIB
        </p>

        <button onclick="toggleDetail(this)" class="text-blue-600 text-sm font-medium hover:underline flex items-center gap-1">
            Lihat Detail
            <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div class="mt-3 hidden text-sm text-gray-600 space-y-1">
            <p><strong>Lokasi:</strong> {{ $event->location }}</p>
        </div>

        @php
            $clubEventStatus = 0;
            if ($user->role_id == 5) {
                $clubEventStatus = $user->club->events->where('event_id', $event->id)->count();
            }
        @endphp

        <div class="grid grid-cols-12 gap-1">
            @if($event->status!=0)
                @if ($this->club->events!=null)
                @if ($this->checkIsRegistered($event->competition_start,$event->competition_end,$event->id)>0)
                    <flux:button wire:navigate href="/club/{{ $event->id }}/event" class="mt-6 px-4 col-span-11 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
                        Masuk
                    </flux:button>
                @else
                    <flux:button wire:click="registerEvent({{ $event->id }})" class="mt-6 px-4 col-span-11 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
                        Daftar
                    </flux:button>
                @endif
                @endif
            @endif

            @if (auth()->user()->role_id == 5)
                @if ($event->club_id == auth()->user()->club->id)
                    <flux:button wire:navigate href="/club/{{ $event->id }}/event" class="mt-6 col-span-1 text-white flex items-center justify-center bg-gray-600 rounded-lg transition" icon="information-circle"></flux:button>
                @endif
            @endif
        </div>
    </div>
</div>

<script>
    function toggleDetail(button) {
        const detail = button.nextElementSibling;
        const icon = button.querySelector('svg');
        detail.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    }
</script>
