<div class="p-6 bg-white dark:bg-gray-900 rounded-2xl shadow-md space-y-6 transition-colors duration-300z">
    @if($athlete)
        {{-- Foto Atlet --}}
        <div class="flex flex-col items-center">
            <img
                src="{{ $athlete->photo == ''
                    ? asset('storage/default.jpg')
                    : asset('storage/athlete/' . $athlete->photo) }}"
                alt="{{ $athlete->first_name }}"
                class="rounded-full w-[250px] h-[250px] object-cover shadow-md"
            >
            <h2 class="mt-4 text-xl font-bold text-gray-800 dark:text-gray-100">
                {{ $athlete->first_name }} {{ $athlete->last_name }}
            </h2>
            <p class="text-gray-500 dark:text-gray-400">
                {{ ucfirst($athlete->gender) }} | {{ date('d F Y',strtotime($athlete->dob)) }}
            </p>
        </div>

        {{-- Detail Atlet --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-600 dark:text-gray-400 font-medium">Nation:</p>
                <p class="text-gray-800 dark:text-gray-100">{{ $athlete->nation }}</p>
            </div>
            <div>
                <p class="text-gray-600 dark:text-gray-400 font-medium">Identity Number:</p>
                <p class="text-gray-800 dark:text-gray-100">{{ $athlete->identity_number }}</p>
            </div>
            <div>
                <p class="text-gray-600 dark:text-gray-400 font-medium">Province:</p>
                <p class="text-gray-800 dark:text-gray-100">{{ $athlete->province }}</p>
            </div>
            <div>
                <p class="text-gray-600 dark:text-gray-400 font-medium">City:</p>
                <p class="text-gray-800 dark:text-gray-100">{{ $athlete->city }}</p>
            </div>
            <div>
                <p class="text-gray-600 dark:text-gray-400 font-medium">Address:</p>
                <p class="text-gray-800 dark:text-gray-100">{{ $athlete->address }}</p>
            </div>
            <div>
                <p class="text-gray-600 dark:text-gray-400 font-medium">Email:</p>
                <p class="text-gray-800 dark:text-gray-100">{{ $athlete->email }}</p>
            </div>
            <div>
                <p class="text-gray-600 dark:text-gray-400 font-medium">Phone:</p>
                <p class="text-gray-800 dark:text-gray-100">{{ $athlete->phone }}</p>
            </div>
            <div>
                <p class="text-gray-600 dark:text-gray-400 font-medium">School:</p>
                <p class="text-gray-800 dark:text-gray-100">{{ $athlete->school }}</p>
            </div>
            <div>
                <p class="text-gray-600 dark:text-gray-400 font-medium">Type:</p>
                <p class="text-gray-800 dark:text-gray-100">{{ $athlete->type }}</p>
            </div>
            <div>
                <p class="text-gray-600 dark:text-gray-400 font-medium">Club:</p>
                <p class="text-gray-800 dark:text-gray-100">
                    {{ $athlete->club?->name ?? 'No Club' }}
                </p>
            </div>
            <div>
                <p class="text-gray-600 dark:text-gray-400 font-medium">Status:</p>
                <p class="{{ $athlete->status ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                    {{ $athlete->status ? 'Active' : 'Inactive' }}
                </p>
            </div>
        </div>
    @else
        <p class="text-center text-gray-500 dark:text-gray-400">No athlete profile found for this parent.</p>
    @endif
</div>
