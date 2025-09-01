<div>
    <x-auth-header :title="__('New Club Registration Form')" :description="__('Enter your details below to create your account')" />

    <form wire:submit="{{ $formType }}" method="POST"  enctype="multipart/form-data" class="overflow-hidden w-full flex items-center justify-center" >
        <div class="flex flex-col gap-2">
            <div class="grid md:grid-cols-2 gap-2 grid-cols-1 my-3">
                <flux:input label="Name" placeholder="Club name" wire:model.live.debounce.1000ms="name"  />
                <flux:input label="Abv" placeholder="Club Abbreviation"  wire:model="nick" />
            </div>
            <flux:input label="Email" placeholder="Club Email"  wire:model="email" />
            <div class="grid md:grid-cols-2 gap-2 grid-cols-1 my-3">
                <flux:input label="Head of Club" placeholder="Name Of Owner" wire:model="leader"  />
                <flux:select wire:model="hoc" label="Head Of Coach">
                @foreach ($coaches as $coach)
                    <flux:select.option value="{{ $coach->id }}">{{$coach->name}}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <flux:select wire:model="training_place_status" label="Training Place Status">
                    <flux:select.option value="1">Owned </flux:select.option>
                    <flux:select.option value="2">Rented</flux:select.option>
                    <flux:select.option value="3">Public Pool</flux:select.option>
                </flux:select>

                <flux:textarea
                label="Training Place "
                placeholder="..."
                wire:model="training_place"
                />


            <div class="grid md:grid-cols-2 gap-2 grid-cols-1 my-3">

                <flux:select wire:model="branchSelect" label=" Sports Branches">
                @foreach ($brnch as $branch)
                    <flux:select.option value="{{ $branch }}">{{$branch}}</flux:select.option>
                    @endforeach
                </flux:select>

                 @if(count($brnch)>0)
                <flux:button
                type="button"  wire:click="addToBranch"  id="addIni" class="cursor-pointer mt-[2em]"
                >Add Branch</flux:button>
                @endif

            </div>
            <ul class="flex">
                @foreach ($clubBranch as $index => $cbrnch)
                    <li
                        class="flex justify-center items-center border-2 border-gray-300 rounded-lg p-1 mx-1 cursor-pointer hover:bg-red-100 transition"
                        wire:click="removeFromBranch({{ $index }})"
                    >
                        {{ $cbrnch }}
                    </li>
                @endforeach
            </ul>
            <flux:input label="Total Member" type="number" placeholder="1" wire:model="member"  />
            <flux:textarea
            label="Club Address"
            placeholder="..."
            wire:model="address"
            />
            <flux:input wire:model="logo" type="file" label="Club Logo "  class="border rounded w-full p-2"  />
            @if ($logo && Str::startsWith($logo->getMimeType(), 'image/'))
            <img src="{{ $logo->temporaryUrl() }}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
            @endif
            <div class="flex mt-2 flex gap-3 mr-2">
                <flux:spacer />
                <flux:button type="submit"  id="ini" class="cursor-pointer"
                wire:loading.attr="disabled"
                wire:target="logo">Add Club</flux:button>
            </div>
        </div>
    </form>
</div>
