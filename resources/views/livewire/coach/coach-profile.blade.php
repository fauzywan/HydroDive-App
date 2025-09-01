<div>

    <livewire:athlete.modal-athlete/>
    @if (session()->has('message'))

    <flux:callout icon="sparkles" color="green">
        <flux:callout.heading>Alert</flux:callout.heading>
        <flux:callout.text>
            {{ session('message') }}
        </flux:callout.text>
    </flux:callout>
    @endif
    <div class="grid grid-cols-4 gap-4">
    <div class="col-span-4 md:col-span-1 justify-self-center">
        <div class="flex h-full w-full flex-col gap-4 rounded-xl justify-center items-center">
          <div class="image relative">
              <img src="{{ $coach->profile==null?asset("storage/default.jpg"):asset("storage/coach/$coach->profile") }}" alt="" class="rounded-full w-[250px] h-[250px] object-cover">
              <svg x-on:click="document.getElementById('pot2').click()"  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 28 25" stroke-width="1.5" stroke="#333" class="bg-white rounded p-1 size-10 rounded-full absolute right-5 bottom-4  text-gray-500 hover:text-gray-700 cursor-pointer">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                </svg>
            </div>

            <div class="flex flex-col items-center">
                <flux:heading size="lg">{{ $coach->name }}</flux:heading>
                <flux:text class="">
                    <p>{{$coach->email}}</p>
                </flux:text>
            </div>
            <flux:text class="mt-2 mb-4">
                <p>{{$coach->address}}</p>
            </flux:text>
                <flux:button icon="plus-circle" wire:click="edit({{$coach->id }})" class="w-full">Edit Profile</flux:button>
        </div>
    </div>
    {{-- BODY --}}
    <div class="col-span-4 md:col-span-3 ">
        <div class="flex justify-center items-center">
            <flux:navbar >
                <flux:navbar.item href="#" wire:click="show(1)">Profile</flux:navbar.item>
                <flux:navbar.item href="#" wire:click="show(3)">Club</flux:navbar.item>
                @if (auth()->user()->role_id!=4)
                <flux:navbar.item href="#" wire:click="show(2)">License</flux:navbar.item>
                @endif
        </flux:navbar>
        </div>
        @if($formShow==2)
        <div class="flex gap-5 flex-wrap justify-center items-center mt-5">
            @foreach ($coach->licenses as $license)
            <div class="w-[200px] overflow-hidden group md:w-[280px] h-[300px] rounded relative" style="border: 2px solid black;box-shadow: 5px 5px black;">
                <img src="{{$license->filename==""?asset('storage/default.jpg'):asset("storage/coach/licenses/$license->filename") }}" alt="Profile Picture" class="object-cover w-full h-[200px]">
               <div class="px-3 py-5">

                   <div class="font-bold mb-2">{{ $license->name }}</div>
                </div>

            </div>
            @endforeach
        </div>

        @elseif($formShow==1)
        <div class="grid grid-cols-2 ">
            <div class="left-area flex flex-col gap-5">
                <div class="heading-subheading">
                    <flux:heading>Name</flux:heading>
                    <flux:text class="">{{ $coach->name }}</flux:text>
                </div>

                <div class="heading-subheading">
                    <flux:heading>Sex</flux:heading>
                    <flux:text class="">{{ $coach->gender }}</flux:text>
                </div>
                <div class="heading-subheading">
                    <flux:heading>Place Of Birth</flux:heading>
                    <flux:text class="">{{ $coach->pob }}</flux:text>
                </div>
                <div class="heading-subheading">
                    <flux:heading>Date Of Birth</flux:heading>
                    <flux:text class="">{{ $coach->dob }}</flux:text>
                </div>
            </div>
            <div class="right-area flex flex-col gap-5">
                <div class="heading-subheading">
                    <flux:heading>Email</flux:heading>
                    <flux:text class="">{{ $coach->email }}</flux:text>
                </div>

                <div class="heading-subheading">
                    <flux:heading>address</flux:heading>
                    <flux:text class="">{{ $coach->city }}</flux:text>
                </div>

            </div>
         </div>
         @elseif($formShow==4)
         <div class="grid grid-cols-2 ">
            <div class="left-area flex flex-col gap-5">
                <div class="heading-subheading">
                    <flux:heading>Club</flux:heading>
                    <flux:text class="">{{ $coach->club->name }}</flux:text>

                </div>
            </div>
        </div>
         @elseif($formShow==3)
         <div class="grid grid-cols-2 ">
            <div class="left-area flex flex-col gap-5">
                <div class="heading-subheading">
                    <flux:heading>Club</flux:heading>
                    <flux:text class="">{{ $coach->club->name }}</flux:text>
                </div>
                <div class="heading-subheading">
                    <flux:heading>Position</flux:heading>
                    <flux:text class="">{{ $coach->title->name   }}</flux:text>
                </div>

            </div>
        </div>
         @elseif($formShow==2)
         <div class="grid grid-cols-2 ">
            <div class="left-area flex flex-col gap-5">
                <div class="heading-subheading">
                    <flux:heading>Email</flux:heading>
                    <flux:text class="">{{ $coach->email }}</flux:text>
                </div>
                <div class="heading-subheading">
                    <flux:heading>Phone Number</flux:heading>
                    <flux:text class="">{{ $coach->phone }}</flux:text>
                </div>
            </div>
            <div class="right-area flex flex-col gap-5">
                <div class="heading-subheading">
                </div>

            </div>
         </div>

         @endif

<div  wire:loading wire:target="profile">

    <div class="absolute right-0 left-0 bottom-0 top-0  flex justify-center items-center">

        <x-loader/>
    </div>
</div>
        <flux:modal name="edit-profile" class="min-w-[22rem]" >
            <div class="space-y-6 flex justify-center items-center w-full
            flex-col">
            <form wire:submit="updateUserProfile" class="flex flex-col justify-center items-center">
                @if ($profile)
                <img src="{{ $profile->temporaryUrl() }}" alt="" class="rounded-full w-[250px] h-[250px] object-cover">
                @endif
                <input type="file" id="pot2" wire:model="profile">


                <div class="flex gap-2">
                    <flux:spacer />


                    <flux:button  x-on:click="document.getElementById('pot2').click()"  class="mt-5">Ubah</flux:button>
                    <flux:button type="submit" class="mt-5">Upload File</flux:button>
                </form>

                </div>
            </div>
        </flux:modal>


    </div>
</div>

</div>
