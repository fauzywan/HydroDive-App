<div>

    @if (session()->has('message'))

    <flux:callout icon="sparkles" color="green">
        <flux:callout.heading>Alert</flux:callout.heading>
        <flux:callout.text>
            {{ session('message') }}
        </flux:callout.text>
    </flux:callout>
    @endif
    <div class="w-full flex justify-end">

    <flux:button wire:click="addLincense">Add License</flux:button>

    </div>

    <div class="overflow-x-auto mt-5 relative">
          <div class="flex gap-5 flex-wrap justify-center items-center mt-5">
              @foreach ($licenses as $license)
              <div class="w-[200px] overflow-hidden group md:w-[280px] h-[300px] rounded relative" style="border: 2px solid black;box-shadow: 5px 5px black;">
                  <img src="{{$license->filename==""?asset('storage/default.jpg'):asset("storage/coach/licenses/$license->filename") }}" alt="Profile Picture" class="object-cover w-full h-[200px]">
                 <div class="px-3 py-5">

                     <div class="font-bold mb-2">{{ $license->name }}</div>
                  </div>
                  <div class="bg-white h-[35%] flex justify-center items-center gap-5 w-full absolute translate-y-[150%] group-hover:translate-y-0 transition duration-300 bottom-[-0]">
                    <button class="w-[80px] p-[4px] rounded-[6px] cursor-pointer text-black" style="border: 2px solid black;" type="button"  id="ini" wire:click="edit({{ $license->id }})">Edit</button>
                    <flux:button variant="danger" wire:click="delete({{ $license->id }})">Delete</flux:button>

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
        {{-- {{ $coaches->links() }} --}}
    </div>


    <flux:modal name="modal-license" class="w-full">
        <form wire:submit="{{ $modal_type==1?'updateLicense':'saveLicense' }}">

            @if($modal_type==2)
            <flux:input wire:model="name" type="text" label=" Name"  class="w-full"/>
            <flux:input wire:model="license_file" placeholder="Name" label="License File" type="file"  class="w-full"/>

            @else
            <flux:input wire:model="name"  label=" Name"  type="text" class="w-full"/>
            @endif

            <flux:button type="submit"
            wire:loading.attr="disabled"
            wire:target="license_file" class="mt-5">{{ $modal_type==1?'Update':'Save' }}</flux:button>
        </form>

    </flux:modal>

    <flux:modal name="delete-profile" class="min-w-[22rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Delete Coach?</flux:heading>

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
