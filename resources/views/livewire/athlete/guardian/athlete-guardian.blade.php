<div>
    <div class="flex w-full">

        <div class="w-full flex justify-end">

                <flux:button icon="plus-circle" wire:navigate href="/guardian/add">Tambah Wali</flux:button>
        </div>
    </div>
    <table id="guardians" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3">Nama</th>
                <th scope="col" class="px-6 py-3">Hubungan</th>
                <th scope="col" class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($guardians as $guardian)
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}</td>
                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $guardian->name }}</td>
                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $guardian->relation }}</td>
                    <td class="px-6 py-2">
                        <flux:button class="text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800" type="button" variant="primary" id="ini" href="guardian/{{$guardian->id}}/edit">Edit</flux:button>
                        <flux:modal.trigger name="delete-profile">
                            <flux:button variant="danger" wire:click="delete({{ $guardian->id }})">Delete</flux:button>
                        </flux:modal.trigger>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
       <div class="mt-5">
        {{ $guardians->links() }}
    </div>

<flux:modal name="delete-profile" class="min-w-[22rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Delete Athlete?</flux:heading>

            <flux:text class="mt-2">
                <p>You're about to delete <b>{{ $first_name }}</b></p>
                <p>This action cannot be reversed.</p>
            </flux:text>
        </div>
        <div class="flex gap-2">
            <flux:spacer />
            <flux:modal.close>
                <flux:button variant="ghost">Cancel</flux:button>
            </flux:modal.close>

            <flux:button type="button" wire:click="destroy" variant="danger">Delete Athlete</flux:button>
        </div>
    </div>

</flux:modal>
</div>
