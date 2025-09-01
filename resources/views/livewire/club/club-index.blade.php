<div>

    @if (session()->has('message'))

    <flux:callout icon="sparkles" color="green">
        <flux:callout.heading>Alert</flux:callout.heading>
        <flux:callout.text>
            {{ session('message') }}
        </flux:callout.text>
    </flux:callout>
    @endif
    <div class="w-full flex justify-end">

        <flux:button href="/club/add" icon="plus-circle">Add club</flux:button>
    </div>
    <x-club-index-navitation :waitingCount="$waitingCount"></x-club-index-navitation>
    <div class="overflow-x-auto mt-5 relative">

        <table id="clubes" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Address</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                   @php
                        use Illuminate\Support\Str;
                        @endphp
                @foreach ($clubs as $club)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $clubs->firstItem() + $loop->index }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $club->name}}</td>

                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                            {{ Str::limit($club->address, 30, '...') }}
                        </td>
                        <td class="px-6 py-2">
                            <flux:badge style="cursor: pointer;" class="text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800" type="badge" variant="primary" id="ini" wire:click="edit({{ $club->id }})">Edit</flux:badge>
                                <flux:badge style="cursor: pointer;"  wire:click="detail({{ $club->id }})">Detail</flux:badge>
                                <flux:badge style="cursor: pointer;" variant="danger" wire:click="delete({{ $club->id }})">Delete</flux:badge>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div wire:loading >
            <div class=" w-full flex justify-center items-center absolute top-0 left-0 right-0 bottom-0 z-50">
                <flux:icon.loading />
            </div>
        </div>
    </div>
    <div class="mt-5">
        {{ $clubs->links() }}
    </div>


    <flux:modal name="delete-profile" class="min-w-[22rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Delete club?</flux:heading>

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
