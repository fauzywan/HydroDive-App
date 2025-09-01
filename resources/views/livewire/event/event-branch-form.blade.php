<div>
    <x-auth-header :title="__('New Event Branch')" :description="__('Add Branch for Selected Event')" />

    <div class="flex justify-center items-center">
        <form wire:submit="{{ $formType }}">
            <div class="mb-5">
                    <div class="mt-2 items-center">
                        <flux:input label="Nama Cabang" class="col-span-2" type="string" readonly wire:model="name_branch" icon:trailing="magnifying-glass"/>
                    </div>

                    <div class="mt-2 items-center">
                        <flux:select wire:model.live="group_age_id" label="Grup Usia">
                        @foreach ($ageGroup as $ag)
                        <flux:select.option value="{{ $ag->id }}">{{$ag->name}} ({{ "$ag->min_age - $ag->max_age" }})</flux:select.option>
                        @endforeach
                        <flux:select.option value="0">Other</flux:select.option>
                    </flux:select>
                    </div>
                    @if($inputNewAge==1)
                    <flux:input label="Nama Grup Usia" type="text" wire:model="group_name" />
                    <div class="grid grid-cols-2 gap-4">
                        <flux:input label="Usia Minimal" type="number" wire:model="minimal_age" />
                        <flux:input label="Usia Maximal" type="number" wire:model="maximal_age" />
                    </div>
                    @endif
                    @if($formType=='save')
                    <div class="mt-2 items-center">
                        <flux:select wire:model.live="isFinal" label="Sesi Pertandingan">
                            <flux:select.option value="0">PRELIM</flux:select.option>
                            <flux:select.option value="1">FINAL</flux:select.option>
                        </flux:select>
                    </div>
                    @endif
                    <div class="mt-2">
                        <flux:input label="Lintasan" type="number" wire:model="line" />
                        <flux:input label="Registration Fee" type="number" wire:model="registration_fee" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <flux:input label="Maksimal Atlit" type="number" wire:model="capacity" />
                        <flux:input label="Atlit per Club" type="number" wire:model="capacity_per_club" />
                    </div>


            </div>

            <div class="flex mt-2 gap-3 mr-2">
                <flux:button type="submit" class="cursor-pointer" wire:loading.attr="disabled">
                    Submit Branch
                </flux:button>
            </div>
        </form>
    </div>

    <flux:modal name="search-branch" class="min-w-[22rem]">
    <div class="flex flex-col justify-between items-center mt-5 mt-2">
        <flux:header>Search Branch</flux:header>
        <div class="flex justify-between items-center mt-5 mt-2">
            <flux:input wire:model.live.debounce.1000ms="keyword" placeholder="Branch Name" />
            <flux:button wire:click="searchKeyword">Search</flux:button>
        </div>

        @if ($branchSearch)
        <div class="flex flex-col mt-2">
            @foreach ($branchSearch as $bc)
            <flux:badge color="zinc" class="cursor-pointer" wire:click="selectOption('{{ $bc->id }}','{{ $bc->description }}','{{ $bc->relay }}')">{{ $bc->description }}</flux:badge>
            @endforeach
        </div>
            @endif

    </div>
</flux:modal>

</div>
