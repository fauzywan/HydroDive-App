<div>
    @if (session()->has('message'))
    <x-message-alert></x-message-alert>
@endif
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
            Manajemen Blog
        </h1>
        <flux:button type="button" icon="plus" wire:navigate href="{{ route('blog.add') }}">
            Tambah Blog
        </flux:button>
    </div>

    {{-- Ringkasan --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4">
            <h2 class="text-sm text-gray-500 dark:text-gray-400">Total Blog</h2>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">
                {{ $blogs->count() }}
            </p>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4">
            <h2 class="text-sm text-gray-500 dark:text-gray-400">Dipublish</h2>
            <p class="text-2xl font-bold text-green-600 mt-2">
                {{ $blogs->where('status', 1)->count() }}
            </p>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4">
            <h2 class="text-sm text-gray-500 dark:text-gray-400">Draft</h2>
            <p class="text-2xl font-bold text-yellow-500 mt-2">
                {{ $blogs->where('status', 0)->count() }}
            </p>
        </div>
    </div>

    {{-- Tabel Data --}}
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th class="px-6 py-3">#</th>
                <th class="px-6 py-3">Judul</th>
                <th class="px-6 py-3">Author</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Tanggal</th>
                <th class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($blogs as $blog)
                <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-900 dark:even:bg-gray-800">
                    <td class="px-6 py-3">{{ $loop->iteration }}</td>
                    <td class="px-6 py-3">{{ $blog->title }}</td>
                    <td class="px-6 py-3">{{ $blog->user->name }}</td>
                    <td class="px-6 py-3">
                        @if($blog->status)
                            <span class="px-2 py-1 text-green-600 bg-green-500/10 rounded">Publish</span>
                        @else
                            <span class="px-2 py-1 text-yellow-600 bg-yellow-500/10 rounded">Draft</span>
                        @endif
                    </td>
                    <td class="px-6 py-3">{{ $blog->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-3 flex gap-2">
                        <flux:button size="sm" icon="eye" href="post/{{ $blog->slug }}" target="_blank">
                            Preview
                        </flux:button>
                        <flux:button size="sm" icon="pencil" wire:navigate href="{{ route('blog.edit', $blog->id) }}">
                            Edit
                        </flux:button>
                        <flux:button size="sm" variant="danger" icon="trash" wire:click="confirmDelete({{ $blog->id }})">
                            Hapus
                        </flux:button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Modal Konfirmasi Hapus --}}
    <flux:modal name="delete-modal" class="min-w-[22rem]">
        <div class="space-y-4">
            <h2 class="text-lg font-bold">Hapus Blog?</h2>
            <p class="text-gray-600 dark:text-gray-300">Apakah Anda yakin ingin menghapus blog ini?</p>
            <div class="flex justify-end gap-2">
                <flux:button variant="ghost" wire:click="closeModal('delete-modal')">Batal</flux:button>
                <flux:button variant="danger" wire:click="delete">Ya, Hapus</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
