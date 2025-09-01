<div>
    @if (session()->has('message'))
    <x-message-alert></x-message-alert>
    @endif

    @if ($formType==1)
    <form wire:submit="startStopwatch">
        <div class="flex mt-5">
                <flux:input wire:model="athlete_name" readonly/>
            <flux:button icon="magnifying-glass" wire:click="searchName"></flux:button>
        </div>
        <div class="flex mt-5">
            <flux:select wire:model="branch_id" >
                @foreach ($events as $admin)
                <flux:select.option value="{{ $admin->event_branch_id }}">{{ $admin->event->name }} ({{ $admin->branch->eventNumber->number ." - ".$admin->branch->age->name }})</flux:select.option>
                @endforeach
            </flux:select>
        </div>
            <flux:button type="submit" class="mt-5">Mulai</flux:butto>
    </form>
     <flux:modal name="search-athlete" class="min-w-[22rem]">
    <div class="flex flex-col justify-between items-center mt-5 mt-2">
        <flux:header>Search Athlete</flux:header>
        <div class="flex justify-between items-center mt-5 mt-2">
            <flux:input wire:model.live.debounce.1000ms="keyword" placeholder="athlete Name" />
            <flux:button wire:click="searchKeyword">Search</flux:button>
        </div>

        @if ($athleteSearch)
        <div class="flex flex-col mt-2 w-full">
            @foreach ($athleteSearch as $bc)
            <flux:badge color="zinc" class="cursor-pointer mb-2 hover:bg-gray-400 hover:text-black" wire:click="selectOption('{{ $bc->id }}','{{ $bc->name() }}')">{{ $bc->name() }}</flux:badge>
            @endforeach
        </div>
            @endif

    </div>
</flux:modal>
@elseif ($formType==2)
<div>
    <div class="flex justify-center items-center">

        <x-event-stopwatch></x-event-stopwatch>
    </div>
    <flux:modal name="finish-modal" class="w-full">
        <form wire:submit.prevent="storeTime">
            <flux:input wire:model="athlete_name" type="text" label="Atlet" readonly />
            <flux:input wire:model="selectedEventName" type="text" label="Perlombaan" readonly/>
            <flux:input wire:model="end_time" type="time" step="0.01" label="Waktu Hasil (detik)" readonly />
            <flux:input wire:model="line" type="number" label="Lintasan" />
         <flux:select wire:model="match_id" label="Sesi Perlombaan">
                @foreach ($matches as $match)
                <flux:select.option value="{{ $match->id }}">{{$match->name}}</flux:select.option>
                @endforeach
            </flux:select>

            <div class="flex justify-end gap-3 mt-4">
                <flux:button type="submit">Simpan</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
    @endif
</div>
