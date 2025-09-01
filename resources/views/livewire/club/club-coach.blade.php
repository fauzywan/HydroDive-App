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


<flux:dropdown>
    <flux:button icon:trailing="chevron-down">Add Coach</flux:button>
    <flux:menu>
        <flux:menu.item icon="plus" href="/coach/add" wire:navigate>New Coach</flux:menu.item>
        <flux:menu.separator />

        <flux:menu.item icon="plus-circle" class="cursor-pointer" wire:click="recruitCoach">Recruit</flux:menu.item>
    </flux:menu>
</flux:dropdown>
    </div>

    <div class="flex justify-center items-center mt-5">
        <flux:input wire:model.live.debounce.500ms="keyword" class=" w-[75%]"  icon="magnifying-glass" placeholder="Search Name" />
    </div>
    <div class="overflow-x-auto mt-5 relative">
          <div class="flex gap-5 flex-wrap justify-center items-center mt-5">
              @foreach ($coaches as $coach)
              <div class="w-[200px] overflow-hidden group md:w-[280px] h-[300px] rounded relative" style="border: 2px solid black;box-shadow: 5px 5px black;">
                  <img src="{{$coach->profile==""?asset('storage/default.jpg'):asset("storage/coach/$coach->profile") }}" alt="Profile Picture" class="object-cover w-full h-[200px]">
                 <div class="px-3 py-5">

                     <div class="font-bold mb-2">{{ $coach->name }}</div>
                     <div class="text-sm">{{ $coach->title->name }}</div>
                  </div>
                  <div class="bg-white h-[35%] flex justify-center items-center gap-5 w-full absolute translate-y-[150%] group-hover:translate-y-0 transition duration-300 bottom-[-0]">
                    <button class="w-[80px] p-[4px] rounded-[6px] cursor-pointer text-black" style="border: 2px solid black;" type="button"  id="ini" wire:click="edit({{ $coach->id }})">Detail</button>
                    <flux:button variant="danger" wire:click="delete({{ $coach->id }})">Delete</flux:button>

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
        {{ $coaches->links() }}
    </div>


    <flux:modal name="search-coach" class="min-w-[22rem]">
        <div class="flex flex-col justify-between items-center mt-5 gap-2">
            <div class="flex justify-between items-center mt-5 gap-2">
                <flux:input wire:model="searchCoach" placeholder="Coach Name"/>
                <flux:button wire:click="searchingCoach">Search</flux:button>
            </div>
            @if($coachSearch)

            @foreach ($coachSearch as $sc)

            <div class="flex justify-center items-center gap-5 mt-2">
                <img src="{{$sc->profile==""?asset('storage/default.jpg'):asset("storage/coach/$sc->profile") }}" alt="Profile Picture" class="object-cover w-[60px] h-[60px] rounded-full">
                <div class="">
                    <flux:heading size="lg">{{ $sc->name }}</flux:heading>
                    <flux:text class="truncate w-[200px]">{{ $sc->email }}</flux:text>
                </div>
                <flux:button wire:click="recruitCoach({{ $sc->id }})" class="mt-5">Recruit</flux:button>
            </div>
            @endforeach
            @endif

        </div>

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
