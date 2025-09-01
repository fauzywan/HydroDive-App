@php
    $modalId = 'modal_' . md5($src);
@endphp

<div>
    <!-- Gambar dengan efek hover -->
    <div class="relative group cursor-pointer" onclick="document.getElementById('{{ $modalId }}').classList.remove('hidden')">
        <img
            src="{{ asset($src) }}"
            alt="Facility Image"
            class="object-cover w-full h-[200px] transition-transform duration-300 group-hover:scale-105"
        >
        <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
            <!-- Ikon Zoom -->
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="lucide text-white">
                <circle cx="12" cy="12" r="3"/>
                <path d="M3 7V5a2 2 0 0 1 2-2h2"/>
                <path d="M17 3h2a2 2 0 0 1 2 2v2"/>
                <path d="M21 17v2a2 2 0 0 1-2 2h-2"/>
                <path d="M7 21H5a2 2 0 0 1-2-2v-2"/>
            </svg>
        </div>
    </div>

    <!-- Modal Gambar Zoom -->
    <div id="{{ $modalId }}" class="hidden fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
        <div class="bg-white p-4 rounded-lg shadow-lg max-w-[90%] max-h-[90%] relative">
            <!-- Tombol Close -->
            <button onclick="document.getElementById('{{ $modalId }}').classList.add('hidden')" class="absolute cursor-pointer top-2 right-2 text-gray-600 hover:text-red-600 transition duration-200 rounded-full p-1 hover:bg-red-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Gambar Zoom -->
            <img src="{{ asset($src) }}" alt="Zoomed Image" class="max-w-full max-h-[80vh] object-contain" />
        </div>
    </div>
</div>
