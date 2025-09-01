<div>
    <x-auth-header :title="__('New Event Form')" :description="__('Add Swimming Event')" />

<div class="flex justify-center items-center">
    <form wire:submit.prevent="{{ $this->formType }}">
        @if ($formStage == 0)
            <div class="mb-5">
                <div class="w-full ml-[2em] flex flex-col gap-5">
                       <flux:select wire:model="club_id" label="Pelaksana">
                        @foreach ($clubs as $club)
                            <flux:select.option value="{{ $club->id }}">{{ $club->id==1?"Federasi":$club->name }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <div class="grid grid-cols-2 gap-4">
                        <flux:input label="Nama Kompetisi" placeholder="Name of Event" wire:model="name" />
                        <flux:input label="Waktu Mulai" type="datetime-local" wire:model="competition_start" />
                    </div>
                    <flux:input label="Lokasi" placeholder="Stadium / Pool Name" wire:model="location" />
                    <flux:textarea label="Deksripsi" placeholder="Optional..." wire:model="description" />
                    <flux:input label="Poster" type="file" wire:model="poster" />
                </div>
            </div>

            <div class="flex mt-2 gap-3 mr-2">
                <flux:button color="gray" wire:click="back" type="button" class="cursor-pointer">
                    ← Back
                </flux:button>
                <flux:spacer />
                <flux:button wire:click="nextnPrev(1)" class="cursor-pointer"
                             wire:loading.attr="disabled"
                             wire:target="poster">Next</flux:button>
            </div>

        @elseif($formStage == 1)
            {{-- PREVIEW --}}
            <div class="preview-label">
                <flux:heading>Pelaksana</flux:heading>
                <flux:text class="mt-2">{{ optional($clubs->find($club_id))->name ?: 'Not
                Filled' }}</flux:text>
            </div>
            <div class="preview-label">
                <flux:heading>Nama Kompetisi</flux:heading>
                <flux:text class="mt-2">{{ $name ?: 'Not Filled' }}</flux:text>
                 <flux:error name="name" />
            </div>


            <div class="preview-label">
                <flux:heading>Waktu Mulai</flux:heading>
                <flux:text class="mt-2">{{ $competition_start ?: 'Not Filled' }}</flux:text>
                 <flux:error name="competition_start" />
            </div>

            <div class="preview-label">
                <flux:heading>Lokasi</flux:heading>
                <flux:text class="mt-2">{{ $location ?: 'Not Filled' }}</flux:text>
                 <flux:error name="location" />
            </div>





            <div class="preview-label">
                <flux:heading>Deksripsi</flux:heading>
                <flux:text class="mt-2">{{ $description ?: 'Not Filled' }}</flux:text>
                 <flux:error name="description" />
            </div>

            <div class="flex mt-2 gap-3 mr-2">
                <flux:button wire:click="nextnPrev(0)" class="cursor-pointer"
                             wire:loading.attr="disabled"
                             wire:target="logo">Prev</flux:button>
                <flux:spacer />
                <flux:button type="submit" id="submitButton" class="cursor-pointer"
                             wire:loading.attr="disabled"
                             wire:target="logo">Submit</flux:button>
            </div>
        @endif
    </form>
</div>

</div>
