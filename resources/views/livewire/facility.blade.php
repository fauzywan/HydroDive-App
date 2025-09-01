<div>
    <div class="mt-5">
    {{-- Heading dan Tombol Tambah --}}
    <div class="flex justify-between items-center mb-4">
        <flux:heading size="lg">Daftar Fasilitas</flux:heading>
        <flux:modal.trigger name="modal-add-facility">
            <flux:button variant="primary">Tambah Fasilitas</flux:button>
        </flux:modal.trigger>
    </div>

    {{-- Tabel Fasilitas --}}
    <div class="overflow-x-auto relative">
        <table id="athletes" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Nama</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($facilities as $index => $facility)
                    <tr class=" border-b dark:border-gray-700 dark:bg-gray-800">
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">{{ $facility->name }}</td>
                        <td class="px-6 py-4">
                            <flux:modal.trigger name="modal-delete-facility">
                                <flux:button variant="danger" wire:click="confirmDelete({{ $facility->id }}, '{{ $facility->name }}')">Delete</flux:button>
                            </flux:modal.trigger>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Tambah Fasilitas --}}
<flux:modal name="modal-add-facility" class="min-w-[22rem]">
    <form wire:submit.prevent="addFacility">
        <div class="space-y-4">
            <flux:heading size="lg">Tambah Fasilitas</flux:heading>
                <flux:field>
                    <flux:label>Nama Fasilitas</flux:label>
                    <flux:input wire:model="newFacilityName"/>
                    <flux:error name="newFacilityName" />
                </flux:field>

            <div class="flex justify-end gap-2 mt-4">
                <flux:modal.close>
                    <flux:button variant="ghost">Batal</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary">Simpan</flux:button>
            </div>
        </div>
    </form>
</flux:modal>

{{-- Modal Hapus Fasilitas --}}
<flux:modal name="modal-delete-facility" class="min-w-[22rem]">
    <div class="space-y-4">
        <flux:heading size="lg">Hapus Fasilitas?</flux:heading>
        <flux:text>Apakah Anda yakin ingin menghapus fasilitas <b>{{ $facilityName }}</b>? Tindakan ini tidak bisa dikembalikan.</flux:text>

        <div class="flex justify-end gap-2 mt-4">
            <flux:modal.close>
                <flux:button variant="ghost">Batal</flux:button>
            </flux:modal.close>
            <flux:button variant="danger" wire:click="deleteFacility">Hapus</flux:button>
        </div>
    </div>
</flux:modal>

</div>
