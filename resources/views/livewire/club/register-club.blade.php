<div>
    <x-auth-header :title="__('Club Form')" :description="__('Form Pendaftaran Klub')" />
    <div class="flex justify-center items-center">
        @if (auth()->user()==null)
        <div class="flex justify-center mt-2">
            <a href="{{ route('login') }}">
                <flux:button class="cursor-pointer" variant="outline">
                    Kembali ke Halaman Login
                </flux:button>
            </a>
        </div>
        @else
        <flux:button wire:click="back"  id="ini" class="cursor-pointer">Back</flux:button>
        @endif
    </div>
    <form wire:submit="{{ $formType }}" method="POST"  enctype="multipart/form-data"
     class="overflow-hidden w-full flex items-center justify-center" >

     @if ($formPage==1)
     <div class="flex flex-col gap-2">
        <div class="grid md:grid-cols-2 gap-2 grid-cols-1 my-3">
            <flux:input label="Name" placeholder="Club name" wire:model="name"  />
            <flux:input label="Abreviasi Klub" placeholder="Club Abbreviation"  wire:model="nick" />
        </div>
        <flux:select wire:model="type_id" label=" Jenis Club">
            @foreach ($clubTypes as $type)
            <flux:select.option value="{{ $type->id }}">{{$type->name}}</flux:select.option>
            @endforeach
        </flux:select>
        <flux:input label="Email" placeholder="Club Email"  wire:model="email" />

        <flux:input label="Password"  type="password" placeholder="Password"  wire:model="password" />
        <flux:input label="Confirm Password" type="password" placeholder="Confirm Password"  wire:model="password_confirmation" />
        <div class="flex mt-2 flex gap-3 mr-2">
            <flux:spacer />

            <flux:button class="cursor-pointer"
            wire:loading.attr="disabled"
            type="button"
            wire:target="logo" wire:click="nextnPrev(1)">Next</flux:button>
        </div>
    </div>
        @elseif ($formPage==2 && $role_id==1)
        <div class="flex flex-col gap-2 w-[50%] items-center">
        <div class="w-full">
            <flux:input label="Registration Fee" placeholder="Registration"  wire:model="club_registration_fee" />
        </div>
            <div class="flex mt-2 flex gap-3 mr-2">
            <flux:spacer />
            <flux:button class="cursor-pointer"
            wire:loading.attr="disabled"
            wire:target="logo" wire:click="nextnPrev(0)">Prev</flux:button>
            <flux:button class="cursor-pointer"
            wire:loading.attr="disabled"
            wire:target="logo" wire:click="nextnPrev(1)">Next</flux:button>
        </div>
    </div>

        @elseif(($formPage==2 && $role_id!=1)|| $formPage==3)
<div class="flex flex-col">

        <div class="flex text-center justify-center items-center">
            <flux:heading>Club Detail</flux:heading>
        </div>
        <div class="grid grid-cols-2">
            <div class="preview-label mb-5">
                <flux:heading>Nama Klub</flux:heading>
                <flux:text>{{ $name == '' ? 'Not Filled' : $name }}</flux:text>
                <flux:error name="name" />
            </div>
            <div class="preview-label mb-5">
                <flux:heading>Abreviasi Klub</flux:heading>
                <flux:text>{{ $nick == '' ? 'Not Filled' : $nick }}</flux:text>
                <flux:error name="nick" />
            </div>
        </div>

        <div class="grid grid-cols-2">
            <div class="preview-label mb-5">
                <flux:heading>Email</flux:heading>
                <flux:text>{{ $email == '' ? 'Not Filled' : $email }}</flux:text>
                <flux:error name="email" />
            </div>

        </div>


    <div class="grid grid-cols-2">
        <div class="preview-label mb-5">
            <flux:heading>Club Type</flux:heading>
            <flux:text>{{ $type_id == '' ? 'Not Filled' : $clubTypes->where('id',$type_id)->first()->name }}</flux:text>
            <flux:error name="type_id" />
        </div>

    </div>
    <div class="preview-label mb-5">
        <flux:heading>Club Logo</flux:heading>
        @if ($logo && Str::startsWith($logo->getMimeType(), 'image/'))
            <img src="{{ $logo->temporaryUrl() }}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
        @else
            <flux:text>Not Filled</flux:text>
        @endif
    </div>

        <div class="flex mt-2 flex gap-3 mr-2">
            <flux:button wire:click="nextnPrev(0)" class="cursor-pointer"
            wire:loading.attr="disabled"
            wire:target="logo">Prev</flux:button>
            <flux:spacer />
            <flux:button type="submit"  id="ini" class="cursor-pointer"
            wire:loading.attr="disabled"
            wire:target="logo">Add Club</flux:button>
        </div>
</div>

        @endif

    </form>
</div>
