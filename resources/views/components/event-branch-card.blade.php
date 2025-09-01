@props(['branch'])

@php
    $isOngoing = $branch->status; // Ubah ini sesuai logika status kompetisi
@endphp

<div x-data="{ open: false }" class="bg-white rounded-2xl shadow-md p-4 space-y-3 w-full max-w-sm">
    <!-- Status -->
    <div>
        <span class="inline-block px-3 py-1 text-sm font-medium rounded-full
            {{ $isOngoing ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-700' }}">
            {{ $isOngoing ? 'Berlangsung' : 'Tidak Aktif' }}
        </span>
    </div>

    <!-- Title -->
    <h3 class="text-lg font-semibold text-gray-900">{{ $branch->name }} ({{ $branch->age->name }})</h3>

    <!-- Date -->
    <p class="text-sm text-gray-500">
        {{-- {{ \Carbon\Carbon::parse($branch->min_age)->translatedFormat('d F Y') }} 16:04 WIB --}}
    </p>

    <!-- Detail Toggle -->
    <button @click="open = !open" class="text-sm text-blue-600 hover:underline flex items-center gap-1">
        Lihat Detail
        <svg :class="{ 'rotate-180': open }" class="transition-transform w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <!-- Detail Section -->
    <div x-show="open" x-collapse x-cloak class="text-sm text-gray-700 space-y-1">
        <div><strong>Kuota:</strong> {{ $branch->current_capacity }}/{{ $branch->capacity }}</div>
        <div><strong>Per Klub:</strong> {{ $branch->capacity_per_club }}</div>
        <div><strong>Biaya:</strong> Rp{{ number_format($branch->registration_fee, 0, ',', '.') }}</div>
        <div><strong>Tahuh Lahir:</strong> {{ $branch->age->min_age }} - {{ $branch->age->max_age }}</div>
        <p class="text-gray-500 italic">{{ $branch->description ?? 'Tidak ada deskripsi.' }}</p>
    </div>
    <div class="grid grid-cols-12 gap-1">
     <flux:button wire:navigate href="/event/{{ $branch->id}}/partisipan" class="mt-6 px-4 col-span-11 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
                Masuk
            </flux:button>
</div>

</div>
