<div>
    @if($club->type_id==2)
     <flux:button icon="plus" wire:click="create" class="cursor-pointer">Create Event</flux:button>
    @endif
    <table id="athletes" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Name</th>
                <th scope="col" class="px-6 py-3">Start</th>
                <th scope="col" class="px-6 py-3">End</th>
                <th scope="col" class="px-6 py-3">Location</th>
                <th scope="col" class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
            <tr>
                <td scope="col" class="px-6 py-3">{{$event->name}}</td>
                <td scope="col" class="px-6 py-3">{{$event->location}}</td>
                <td scope="col" class="px-6 py-3">{{$event->start_event}}</td>
                <td scope="col" class="px-6 py-3">{{$event->end_event}}</td>
                <td>
                    <flux:button icon="pencil" wire:click="edit({{ $event->id }})" class="cursor-pointer">Edit</flux:button>
                    <flux:button icon="trash" wire:click="delete({{ $event->id }})" class="cursor-pointer">Delete</flux:button>
                </td>
                @endforeach
            </tbody>
        </table>
</div>
