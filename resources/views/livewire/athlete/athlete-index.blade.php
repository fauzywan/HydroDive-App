<div>

@if (session()->has('message'))
    <x-message-alert></x-message-alert>
@endif
    <div class="mt-5 grid-cols-3 grid gap-2">
        <flux:callout icon="users" color="blue">
            <flux:callout.heading>Total Athletes</flux:callout.heading>
            <flux:callout.text>
           <b>{{ $athletes->total() }}</b> athletes
            </flux:callout.text>
        </flux:callout>
        <flux:callout icon="users" color="green">
            <flux:callout.heading>Male</flux:callout.heading>
            <flux:callout.text>
                <b>{{ $MaleTotal }}</b> athletes
            </flux:callout.text>
        </flux:callout>
        <flux:callout icon="users" color="pink">
            <flux:callout.heading>Female</flux:callout.heading>
            <flux:callout.text>
               <b>{{ $athletes->total()-$MaleTotal>0?$athletes->total()-$MaleTotal:0 }}</b> athletes
            </flux:callout.text>
        </flux:callout>
    </div>
    {{-- <div class="mt-5 grid-cols-4 grid">
        <div class="col-span-3">
            @if ($sortBy==1)
            <flux:input wire:model.live.debounce.1000ms="keyword" icon="magnifying-glass" placeholder="Search Name" />
            @else
                <flux:select size="sm" placeholder="Sex"  wire:model.live.debounce.1000ms="keyword">
                <flux:select.option selected>Male</flux:select.option>
                <flux:select.option>Female</flux:select.option>
            </flux:select>
            @endif
        </div>
        <div class="col-span-1">

            <flux:select wire:model="sortBy" wire:change="sortING">
                <flux:select.option value="1">Name</flux:select.option>
                <flux:select.option value="2">Sex</flux:select.option>
            </flux:select>
        </div>

    </div> --}}
     <div class="flex w-full mt-2 gap-2">
        <flux:input kbd="âK" wire:model.live.debounce.1000ms="keyword" icon="magnifying-glass" placeholder="Search..."/>
           <flux:button icon="plus-circle" href="/athlete/add">Add Athlete</flux:button>
    </div>
    <div class="overflow-x-auto mt-5 relative">

        <table id="athletes" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
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
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $athletes->firstItem() + $loop->index }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $athlete->first_name." ". $athlete->lastName }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $athlete->gender }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $athlete->city }}</td>
                        <td class="px-6 py-2">
                            <flux:button class="text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800" type="button" variant="primary" id="ini" href="athlete/{{$athlete->id}}/edit">Edit</flux:button>
                            <flux:button class="text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800" type="button" variant="primary" id="ini" href="athlete/{{$athlete->id}}/profile">Detail</flux:button>
                                <flux:button variant="danger" wire:click="delete({{ $athlete->id }})">Delete</flux:button>
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
        {{ $athletes->links() }}
    </div>
    {{-- MODAL DELETE --}}

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
