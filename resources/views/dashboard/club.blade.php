<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Statistik Ringkas -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <!-- Jumlah Atlet -->
            <div class="rounded-xl border border-gray-200 p-4 shadow-sm bg-white dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Jumlah Atlet</h2>
                <div class="text-2xl font-bold text-blue-600">
                    {{ $athleteCount }}
                </div>
            </div>

            <!-- Jumlah Pelatih -->
            <div class="rounded-xl border border-gray-200 p-4 shadow-sm bg-white dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Jumlah Pelatih</h2>
                <div class="text-2xl font-bold text-green-600">
                    {{ $coachCount }}
                </div>
            </div>

            <!-- Total Kompetisi -->
            <div class="rounded-xl border border-gray-200 p-4 shadow-sm bg-white dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Kompetisi yang Diikuti</h2>
                <div class="text-2xl font-bold text-yellow-600">
                    {{ $kompetisiCount }}
                </div>
            </div>
        </div>

        <!-- Grid Konten Bawah: Daftar Atlet dan Jadwal -->
        <div class="grid md:grid-cols-2 gap-4 items-start">
            <!-- Daftar Atlet -->
            <div class="rounded-xl border border-gray-200 p-4 shadow-sm bg-white dark:border-neutral-700 dark:bg-neutral-900">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Daftar Atlet</h3>
               <ul class="space-y-3">
            @forelse ($athletes as $athlete)
                <li class="flex items-center gap-4 p-2 rounded-md hover:bg-gray-50 dark:hover:bg-neutral-800 transition">
                    {{-- Avatar --}}
                    <div class="flex-shrink-0">
                        @if($athlete->avatar)
                            <img src="{{ asset('storage/athlete' . $athlete->photo) }}" alt="photo" class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold">
                                {{ strtoupper(substr($athlete->first_name, 0, 1) . substr($athlete->last_name, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1">
                        <p class="font-medium text-gray-800 dark:text-white">{{ $athlete->first_name }} {{ $athlete->last_name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Usia: {{ $athlete->age() }} tahun</p>
                    </div>

                    {{-- Tombol --}}
                </li>
            @empty
                <li class="text-gray-500 dark:text-gray-400">Belum ada atlet.</li>
                @endforelse
                @if($athletes)
                <div class="flex justify-center items-center">
                    <flux:button variant="primary" class="hover:text-blue-500 text-sm bg-blue-500 w-full text-white font-bold" href="/club/athlete"><b>Lihat Lebih Banyak</b></flux:button>
                </div>
                @endif
            </ul>
            </div>

            <!-- Jadwal Latihan -->
            <div class="rounded-xl border border-gray-200 p-4 shadow-sm bg-white dark:border-neutral-700 dark:bg-neutral-900">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Jadwal Latihan Hari ini</h3>
                <ul class="space-y-3">
                    @forelse ($schedules as $schedule)
                        <li class="border-b pb-2">
                            <p class="font-semibold">{{ $schedule->getDay() }}</p>
                            <p class="text-sm text-gray-500">Jam: {{ $schedule->time_start }} -  {{ $schedule->time_end }}</p>
                        </li>
                    @empty
                        <li class="text-gray-500">Belum ada jadwal latihan.</li>
                    @endforelse
                </ul>
                @if ($schedules->count()>0)
                <div class="flex justify-center items-center mt-5">
                    <flux:button variant="primary" class="hover:text-blue-500 text-sm bg-blue-500 w-full text-white font-bold" href="/club/schedule"><b>Lihat Lebih Banyak</b></flux:button>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
