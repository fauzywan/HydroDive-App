<div>
    <flux:button wire:click="back"  id="ini" class="cursor-pointer">Back</flux:button>

    <div class="relative mb-5 flex justify-center items-center flex-col">
        <flux:heading>{{ __('Coach Form') }}</flux:heading>
        {{-- <flux:subheading>{{ __('Set Your Password To Default') }}</flux:subheading> --}}
    </div>
    <form wire:submit="{{ $formType }}" method="POST"  enctype="multipart/form-data" class="overflow-hidden w-full flex items-center justify-center" >
        <div class="w-[75%]  flex flex-col ">
            <flux:input label="Name" placeholder="Coach name" wire:model="name" />
            <flux:error name="name" />
            <div class="grid md:grid-cols-2 gap-2 grid-cols-1 my-3">
                <flux:input icon="identification" label="Place of Birth" type="text" wire:model="pob" />
                <flux:error name="pob" />
                <flux:input label="Date of birth" type="date"  wire:model="dob" />
                <flux:error name="dob" />
            </div>
            <div class="grid md:grid-cols-2 gap-2 grid-cols-1 my-3">
                <flux:input icon="identification" label="City" type="text" wire:model="city" />
                <flux:error name="city" />
                <flux:input label="Email" type="email"  wire:model="email" />
                <flux:error name="email" />
            </div>
            <flux:select wire:model="category" label="Category" class="mb-3">
                @foreach ($categories as $category)
                <flux:select.option value="{{ $category->name }}">{{$category->name}}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:error name="category" />

            <flux:select wire:model="gender" label="gender" >
                <flux:select.option value="male">male</flux:select.option>
                <flux:select.option value="female">female</flux:select.option>
            </flux:select>
            <flux:error name="gender" />


            <flux:select wire:model="club" label="club" class="mb-5" >
                @foreach ($clubs as $club)
                <flux:select.option value="{{ $club->nick }}">{{ $club->name }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:error name="club" />

            <flux:input wire:model="profile" type="file"  class="border rounded w-full p-2"   label="Coach Image"  />
            @if ($profile)
            <img src="{{ $profile->temporaryUrl() }}" alt="" class="rounded-full w-[250px] h-[250px] object-cover mt-2">
            @endif
            <div class="flex mt-2 flex gap-3 mr-2">
                <flux:spacer />
                <flux:button type="submit"  id="ini" class="cursor-pointer"
                wire:loading.attr="disabled"
                wire:target="licenses"
                wire:target="profile">{{ $formType="save"?"Add":"Update" }} Coach</flux:button>
            </div>
        </div>

</form>
</div>
