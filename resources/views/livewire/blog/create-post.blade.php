<div class="p-6 max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">
        {{ $blogId ? 'Edit Blog' : 'Tambah Blog Baru' }}
    </h1>

    {{-- Alert Sukses --}}
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="store" class="space-y-6">
        {{-- Judul --}}
                {{-- Status --}}
    {{-- Status --}}

        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                Judul
            </label>
            <input type="text" wire:model.live="title"
                class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600">
            @error('title')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
{{-- Slug --}}
<div>
    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
        Slug
    </label>
    <input type="text" wire:model="slug"
        class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600">
    @error('slug')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>
        {{-- Konten --}}
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                Konten
            </label>
            <textarea wire:model="content" rows="12"
                class="w-full border rounded-lg p-3 text-base leading-relaxed focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600"></textarea>
            @error('content')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Thumbnail --}}
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                Thumbnail
            </label>
            <input type="file" wire:model="thumbnail"
                class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4
                       file:rounded-lg file:border-0
                       file:text-sm file:font-semibold
                       file:bg-blue-50 file:text-blue-700
                       hover:file:bg-blue-100
                       dark:file:bg-gray-700 dark:file:text-gray-200">

            @error('thumbnail')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror

            {{-- Thumbnail lama (kalau edit dan belum upload baru) --}}
            @if ($oldThumbnail && !$thumbnail)
                <div class="mt-3">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Thumbnail saat ini:</p>
                    <img src="{{ asset('storage/'.$oldThumbnail) }}" class="w-40 h-28 object-cover rounded-lg shadow">
                </div>
            @endif

            {{-- Preview thumbnail baru --}}
            @if ($thumbnail)
                <div class="mt-3">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Preview:</p>
                    <img src="{{ $thumbnail->temporaryUrl() }}" class="w-40 h-28 object-cover rounded-lg shadow">
                </div>
            @endif
        </div>

<div>
    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
        Status
    </label>
    <div class="flex items-center space-x-6">
        <!-- Draft -->
        <label class="flex items-center space-x-2 cursor-pointer">
            <input type="radio" wire:model="status" value="0"
                class="w-5 h-5 text-blue-600 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600">
            <span class="text-gray-700 dark:text-gray-300">Draft</span>
        </label>

        <!-- Publish -->
        <label class="flex items-center space-x-2 cursor-pointer">
            <input type="radio" wire:model="status" value="1"
                class="w-5 h-5 text-blue-600 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600">
            <span class="text-gray-700 dark:text-gray-300">Publish</span>
        </label>
    </div>
</div>

        {{-- Tombol Submit --}}
        <div>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg font-medium shadow">
                {{ $blogId ? 'Update' : 'Simpan' }}
            </button>
        </div>
    </form>
</div>
