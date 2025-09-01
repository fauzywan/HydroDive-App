<div>
    @if (session()->has('message'))
    <flux:callout icon="sparkles" color="green">
        <flux:callout.heading>Alert</flux:callout.heading>
        <flux:callout.text>
            {{ session('message') }}
        </flux:callout.text>
    </flux:callout>
    @endif
    <div class="flex flex-end items-end justify-end mb-2">
        <flux:button icon="plus"  wire:click="addFacility">New facility</flux:button>

    </div>
       <div class="flex justify-center items-center mt-5">
        <flux:input wire:model.live.debounce.500ms="keyword" class=" w-[75%]"  icon="magnifying-glass" placeholder="Search Name" />
    </div>
    <div class="overflow-x-auto mt-5 relative">
          <div class="flex gap-5 flex-wrap justify-center items-center mt-5">
              @foreach ($facilities as $facility)
              <div class="w-[200px] overflow-hidden group md:w-[280px] h-[300px] rounded relative" style="border: 2px solid black;box-shadow: 5px 5px black;">
                  <x-image-hover :src="$facility->photo" :location="'storage/club/facility/'"></x-image-hover>

                 <div class="px-3 py-5">
                     <div class="font-bold mb-2">{{ $facility->name }}</div>
                     {{-- <div class="text-sm">{{ $facility->desc }}</div> --}}
                  </div>
                  <div class="bg-white h-[35%] flex justify-center items-center gap-5 w-full absolute translate-y-[150%] group-hover:translate-y-0 transition duration-300 bottom-[-0]">
                    <button class="w-[80px] p-[4px] rounded-[6px] cursor-pointer text-black" style="border: 2px solid black;" type="button"  id="ini" wire:click="profile({{ $facility->id }})">Detail</button>
                    <flux:button variant="danger" wire:click="delete({{ $facility->id }})">Delete</flux:button>

                  </div>
              </div>
              @endforeach
          </div>


        <div wire:loading >
            <div class=" w-full flex justify-center items-center absolute top-0 left-0 right-0 bottom-0 z-50">
                <flux:icon.loading />
            </div>
        </div>
    </div>
    <div class="mt-5">
        {{-- {{ $facilityes->links() }} --}}
    </div>

    <flux:modal name="detail-facility" class="min-w-[22rem]" >
         <div class="grid grid-cols-2">
            <div class="preview-label mb-5">
                <flux:heading>Name</flux:heading>
                <flux:text>{{ $name == '' ? 'Not Filled' : $name }}</flux:text>
            </div>
            <div class="preview-label mb-5">
                <flux:heading>Facility Status</flux:heading>
                <flux:text>{{ $statusFacility == '' ? 'Not Filled' : $statusFacility }}</flux:text>
            </div>
        </div>
        <div class="preview-label mb-5">
            <flux:heading>Description</flux:heading>
            <flux:text>{{ $desc == '' ? 'Not Filled' : $desc }}</flux:text>
        </div>
        <flux:button wire:click="edit" class="w-full">Edit</flux:button>
    </flux:modal>
       <flux:modal name="modal-form" class="w-full" >
        <form wire:submit="{{ $formType }}" >

            <flux:select wire:model="name" label="Nama Fasilitas" wire:key="name">
                @foreach ($facilityCategory as $fc)
                <flux:select.option value="{{ $fc->name }}">{{$fc->name}}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:select wire:model="status" label="Status Kepemilikan" wire:key="status">
                <flux:select.option value="1">Dimiliki</flux:select.option>
                <flux:select.option value="2">Sewa</flux:select.option>
                <flux:select.option value="3">Kolam Umum</flux:select.option>
            </flux:select>
            <flux:textarea
            label="Description"
            placeholder=""
        wire:model="desc"
        />
        @if ($formType!="update")
        <flux:input wire:model="photo" type="file" label="Facility Picture "  class="border rounded w-full p-2"  />
        @endif
        @if ($photo && Str::startsWith($photo->getMimeType(), 'image/'))
        <img src="{{ $photo->temporaryUrl() }}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
        @endif
        <div class="flex mt-2 flex gap-3 mr-2">
            <flux:spacer />

            <flux:button class="cursor-pointer"
            wire:loading.attr="disabled"
            type="submit"
            wire:target="photo">Save</flux:button>
        </div>
    </form>
    </flux:modal>

    <flux:modal name="delete-profile" class="min-w-[22rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Delete facility?</flux:heading>

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
