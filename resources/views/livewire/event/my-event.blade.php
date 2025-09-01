<div>
<style>
    table tbody td:nth-child(3),
    table thead th:nth-child(3)
    {
    text-align: center;
    }
</style>
    @if (session()->has('message'))

<flux:callout icon="sparkles" color="green">
    <flux:callout.heading>Alert</flux:callout.heading>
    <flux:callout.text>
        {{ session('message') }}
    </flux:callout.text>
</flux:callout>
@endif

<div class="mt-5 grid-cols-3 grid gap-2">
    <flux:callout icon="users" color="blue">
        <flux:callout.heading>Total </flux:callout.heading>
        <flux:callout.text>
        <b>{{ $events->total() }}</b> events
        </flux:callout.text>
    </flux:callout>
    <flux:callout icon="users" color="green">
        <flux:callout.heading>Berlangsung</flux:callout.heading>
        <flux:callout.text>
            {{ $events->total() - $nonActiveEvent}}
        </flux:callout.text>
    </flux:callout>
    <flux:callout icon="users" color="pink">
        <flux:callout.heading>Selesai</flux:callout.heading>
        <flux:callout.text>
            {{ $nonActiveEvent}}
        </flux:callout.text>
    </flux:callout>
</div>
<div class="flex w-full mt-2 gap-2">
        <flux:input wire:model.live.debounce.1000ms="keyword" icon="magnifying-glass" placeholder="Search Name" />
        <div class="flex w-full">
    @if($club)
    <div class="w-full flex justify-end">
        @if ($club->status==1)
        <flux:button icon="plus-circle" href="/event/add" wire:navigate>Buat Kompetisi</flux:button>
        @endif
    </div>
    @endif
</div>
</div>
<div class="overflow-x-auto mt-5 relative">
    <table id="events" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3">Nama</th>
                <th scope="col" class="px-6 py-3">Status</th>
                <th scope="col" class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
                <tr class="">
                    <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $events->firstItem() + $loop->index }}</td>
                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $event->name }}</td>
                    <td class="px-6 py-2">
                            {!! $this->badgeStatus($event->status) !!}
                    </td>
                    <td class="px-6 py-2">
                        <x-badge-href color="blue" href="/event/{{$event->id}}/edit">Edit</x-badge-href>
                        <span  wire:click="delete({{ $event->id }})">
                            <x-badge-href color="red">Delete</x-badge-href>
                        </span>
                        {{-- <span  wire:click="duplicate({{ $event->id }})">
                            <x-badge-href color="sky" >Duplicate</x-badge-href>
                        </span> --}}
                        <x-badge-href color="green" href="/event/{{$event->id}}/detail">detail</x-badge-href>
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
    {{-- MODAL DELETE --}}

<flux:modal name="delete-event" class="min-w-[22rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Delete Event?</flux:heading>

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

            <flux:button type="button" wire:click="destroy" variant="danger">Delete event</flux:button>
        </div>
    </div>

</flux:modal>
</div>
