<div>
    @if (session()->has('message'))
        <x-message-alert></x-message-alert>
    @endif
    <flux:heading>Group Age</flux:heading>
    <div class="flex justify-end">
        <flux:button wire:click="addGroup" class="mb-5">
            Tambah Grup Usia
        </flux:button>
    </div>
    <div class="flex justify-between items-center mb-5 w-full"></div>
    <div class="overflow-x-auto mt-5 relative">
        <table id="athletes" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Nama</th>
                    <th scope="col" class="px-6 py-3">Minimal</th>
                    <th scope="col" class="px-6 py-3">Maximal</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groupAges as $age)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                            {{ $groupAges->firstItem() + $loop->index }}
                        </td>
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                            {{ $age->name}}
                        </td>
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                            {{ $age->min_age}} Tahun ({{ date('Y')-$age->min_age  }})
                        </td>
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                            {{ $age->max_age}} Tahun ({{ date('Y')-$age->max_age  }})
                        </td>
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                            <flux:badge color="blue" class="active:scale-[0.9] hover:bg-red-50 cursor:pointer" wire:click="edit('{{ $age->id }}')">
                                edit
                        </flux:badge>
                            <flux:badge color="red" class="active:scale-[0.9] hover:bg-red-50 cursor:pointer" wire:click="delete('{{ $age->id }}','{{ $age->name }}')">
                                Hapus
                        </flux:badge>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div wire:loading>
            <div class="w-full flex justify-center items-center absolute top-0 left-0 right-0 bottom-0 z-50">
                <flux:icon.loading />
            </div>
        </div>
    </div>

    <div class="mt-5">
        {{ $groupAges->links() }}
    </div>

    <flux:modal name="confirm-modal" class="min-w-[22rem]" >
    <div class="space-y-4">

        <flux:heading size="lg">
            Data Tidak Dapat Dipulihkan
        </flux:heading>
        <flux:text>
            Apakah Anda yakin ingin Menghapus Grup Usia <b>{{ $group_name }}</b>?
        </flux:text>
        <div class="flex justify-end gap-2">
            <flux:modal.close>
                <flux:button variant="ghost">Batal</flux:button>
            </flux:modal.close>
            <form wire:submit.prevent="destroy">
                <flux:button type="submit" variant="danger">
                    Ya, Lanjutkan
                </flux:button>
            </form>
        </div>
    </div>
</flux:modal>
<flux:modal name="form-modal" class="min-w-[22rem]">
       <form wire:submit="{{ $formType }}" >
            <flux:input wire:model="name" label="Nama" wire:key="name" class="mb-2" />
        <div class="flex">
            <flux:input wire:model="min_age" label="Usia Minimal" type="number" wire:key="min_age" class="w-full mr-2"/>
            <flux:input wire:model="max_age" label="Usia Maksimal" type="number" wire:key="max_age" class="w-full ml-2"/>
        </div>
        <div class="flex mt-2 flex gap-3 mr-2">
            <flux:spacer />
            <flux:button class="cursor-pointer"
            wire:loading.attr="disabled"
            type="submit"
            wire:target="photo">Save</flux:button>
        </div>
        </form>
    </flux:modal>


</div>
