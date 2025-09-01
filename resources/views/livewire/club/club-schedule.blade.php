<div>
    @if (session()->has('message'))

    <flux:callout icon="sparkles" color="green">
        <flux:callout.heading>Alert</flux:callout.heading>
        <flux:callout.text>
            {{ session('message') }}
        </flux:callout.text>
    </flux:callout>
    @endif

    @if (auth()->user()->role_id==4)
    @if (auth()->user()->coach->club_id==1)
    <flux:callout icon="sparkles" color="red">
        <flux:callout.heading>Info</flux:callout.heading>
        <flux:callout.text>
            Anda Belum Tergabung Klub Manapun
        </flux:callout.text>
    </flux:callout>
    @endif
    @endif
    @if (auth()->user()->role_id==5)
    <div class="w-full flex justify-end">
        <flux:button icon="plus-circle" wire:click="addSchedule">Add Schedule</flux:button>
    </div>
    @endif
            <div class="overflow-x-auto mt-5 relative">
        <table id="schedules" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Day</th>
                    <th scope="col" class="px-6 py-3">Time</th>
                    <th scope="col" class="px-6 py-3">Location</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schedules as $schedule)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{  $loop->iteration }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $schedule->getDay()}}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ \Carbon\Carbon::parse($schedule->time_start)->format('H:i') }}  -  {{ \Carbon\Carbon::parse($schedule->time_end)->format('H:i') }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $schedule->location}}</td>
                        <td class="px-6 py-2">
                            <flux:button class="text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800" type="button" variant="primary" id="ini" wire:click="edit({{$schedule->id}})">Edit</flux:button>
                            <flux:modal.trigger name="delete-profile">
                                <flux:button variant="danger" wire:click="delete({{ $schedule->id }})">Delete</flux:button>
                            </flux:modal.trigger>
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
        {{-- {{ $schedules->links() }} --}}
    </div>
    <flux:modal name="modal-schedule" class="md:w-96">
        <form wire:submit="{{ $formType }}" >

    @if ($modalType==1)
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Delete project?</flux:heading>
            <flux:text class="mt-2">
                <p>You're about to delete this project.</p>
                <p>This action cannot be reversed.</p>
            </flux:text>
        </div>
        <div class="flex gap-2">
            <flux:spacer />
            <flux:modal.close>
                <flux:button variant="ghost">Cancel</flux:button>
            </flux:modal.close>
            <flux:button type="submit" variant="danger">Delete project</flux:button>
        </div>
    </div>
    @else
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Club Schedule</flux:heading>
            <flux:text class="mt-2">Add / Edit Club Training Schedule</flux:text>
        </div>
            <flux:select wire:model="day" placeholder="Choose day..." label="Day">
                <flux:select.option value="1">Monday</flux:select.option>
                <flux:select.option value="2">Tuesday</flux:select.option>
                <flux:select.option value="3">Wednesday</flux:select.option>
                <flux:select.option value="4">Thursday</flux:select.option>
                <flux:select.option value="5">Friday</flux:select.option>
                <flux:select.option value="6">Saturday</flux:select.option>
                <flux:select.option value="7">Sunday</flux:select.option>
            </flux:select>
            <div class="grid grid-cols-2 gap-2">

                <flux:input label="Time Start" type="time" wire:model="time_start" />
                <flux:input label="Time End" type="time" wire:model="time_end"/>
            </div>
            <flux:input label="Location" type="text" wire:model="location"/>

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">Save changes</flux:button>
            </div>
        </div>

        @endif
    </form>

    </flux:modal>
</div>
