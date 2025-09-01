 <div>
    <div class="flex flex-end justify-end gap-2">
        <livewire:modalAthlete/>
        <flux:modal.trigger name="athlete-modal" id="th" >
            <flux:button icon="plus-circle" wire:click="changeFormType('save')">Add Athlete</flux:button>
        </flux:modal.trigger>
    </div>
    <div class="overflow-x-auto mt-5">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Gender</th>
                    <th scope="col" class="px-6 py-3">City</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($athletes as $athlete)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">2</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $athlete->name }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $athlete->gender }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $athlete->city }}</td>
                        <td class="px-6 py-2">

                            <flux:button class="text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800" type="button" variant="primary" id="ini" wire:click="edit({{ $athlete->id }})">Edit</flux:button>
                            <flux:modal.trigger name="delete-profile">
                                <flux:button variant="danger" wire:click="delete({{ $athlete->id }})">Delete</flux:button>
                            </flux:modal.trigger>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</div>
