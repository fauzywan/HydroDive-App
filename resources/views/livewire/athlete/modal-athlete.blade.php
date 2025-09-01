<div class="flex">
    <flux:modal name="athlete-modal" class="md:w-full " wire:submit="{{$this->formType}}">
        <form class="overflow-hidden">
            <div class=" mb-5 w-[300%] flex md:gap-[5em] sm:gap-[2em] justif-center trans transition  duration-300 ease-in-out items-center"style=" transform:translateX(-{{$formStage*34}}%)">
            <div class="first-stage w-full ml-[2em] flex flex-col gap-5" id="firstStage">
                <div class="grid grid-cols-2 gap-2">
                    <flux:input label="First Name" placeholder="Your name" wire:model="first_name" />
                    <flux:input label="Last Name" placeholder="Your name" wire:model="last_name" />
                </div>
                <div class="grid md:grid-cols-2 gap-2 grid-cols-1">
                    <flux:input icon="identification" label="NIK/NISD" type="number" wire:model="identity_number" />
                    <flux:input label="Date of birth" type="date"  wire:model="dob" />
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <flux:input icon="at-symbol" label="Phone" type="text" wire:model="phone" />
                    <flux:input icon="at-symbol" label="Your Email" type="email" wire:model="email" />
                </div>
                <flux:input icon="globe-alt" label="Nation" type="text" wire:model="nation"/>
                <div class="grid grid-cols-2 gap-2">
                    <flux:input icon="globe-europe-africa" label="Province" type="text" wire:model="province" />
                    <flux:input icon="globe-asia-australia" label="City" type="text" wire:model="city" id="goToNext" />
                </div>
            </div>
            <div class="second-stage w-full ml-2">
                  @if(auth()->user()->role_id==1)
                <flux:select wire:model="club_id" label="Club">
                    @foreach ($clubs as $club)
                    <flux:select.option value="{{ $club->nick }}">{{$club->name}}</flux:select.option>
                    @endforeach
                </flux:select>
                @endif
                <flux:select wire:model="gender" label="Gender" wire:key="{{ isset($athlete)?$athlete->gender:'female' }}">
                    <flux:select.option value="male">male</flux:select.option>
                    <flux:select.option value="female">female</flux:select.option>
                </flux:select>
                <flux:textarea
                label="Address"
                placeholder="..."
                wire:model="address"
                />
                <flux:input wire:model="photo" type="file"  class="border rounded w-full p-2"  />
            </div>
            <div class="third-stage w-full">
                <div class="preview-label">
                    <flux:heading>First Name</flux:heading>
                    <flux:text class="mt-2">{{ $first_name==''?'Not Filled':$first_name }}</flux:text>
                    <flux:error name="first_name" />
                </div>
                <div class="preview-label">
                    <flux:heading>Last Name</flux:heading>
                    <flux:text class="mt-2">{{ $last_name==''?'Not Filled':$last_name }}</flux:text>
                    <flux:error name="last_name" />
                </div>
                <div class="preview-label">
                    <flux:heading>Nik</flux:heading>
                    <flux:text class="mt-2">{{ $identity_number==''?'Not Filled':$identity_number }}</flux:text>
                    <flux:error name="identity_number" />
                </div>
                <div class="preview-label">
                    <flux:heading>Date Of Birth</flux:heading>
                    <flux:text class="mt-2">{{ $dob==''?'Not Filled':$dob }}</flux:text>
                    <flux:error name="dob" />
                </div>
                <div class="preview-label">
                    <flux:heading>Sex</flux:heading>
                    <flux:text class="mt-2">{{ $gender==''?'Not Filled':$gender }}</flux:text>
                    <flux:error name="gender" />
                </div>
                <div class="preview-label">
                    <flux:heading>Province</flux:heading>
                    <flux:text class="mt-2">{{ $province==''?'Not Filled':$province }}</flux:text>
                    <flux:error name="province" />
                </div>
                <div class="preview-label">
                    <flux:heading>Email</flux:heading>
                    <flux:text class="mt-2">{{ $email==''?'Not Filled':$email }}</flux:text>
                    <flux:error name="email" />
                </div>
                <div class="preview-label">
                    <flux:heading>Phone</flux:heading>
                    <flux:text class="mt-2">{{ $phone==''?'Not Filled':$phone }}</flux:text>
                    <flux:error name="phone" />
                </div>
                <div class="preview-label">
                    <flux:heading>Nation</flux:heading>
                    <flux:text class="mt-2">{{ $nation==''?'Not Filled':$nation }}</flux:text>
                    <flux:error name="nation" />
                </div>

                <div class="preview-label">
                    <flux:heading>City</flux:heading>
                    <flux:text class="mt-2">{{ $city==''?'Not Filled':$city }}</flux:text>
                    <flux:error name="city" />
                </div>
                <div class="preview-label">
                    <flux:heading>Address</flux:heading>
                    <flux:text class="mt-2">{{ $address==''?'Not Filled':$address }}</flux:text>
                    <flux:error name="address" />
                </div>

                <div class="preview-label">
                    <flux:heading>Photo Preview:</flux:heading>
                    @if ($photo)
                    <img src="{{ $photo->temporaryUrl() }}">
                @endif
                </div>
            </div>
        </div>
            <div class="flex mt-2 flex gap-5 mr-2">
                <flux:spacer />
                @if($formStage>0)
                <flux:button class="cursor-pointer" type="button" wire:click="prevForm">{{ $prevButton }}</flux:button>
                @endif
                <flux:button id="ini" class="cursor-pointer" type="{{ $formStage==2?'submit':'button' }}" variant="primary"  wire:click="{{ $formStage==2?'':'nextForm' }}">{{ $nextButton }}</flux:button>
        </div>

    </form>
</flux:modal>


{{-- MODAL DELETE --}}
<script>
document.getElementById('goToNext').addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            e.preventDefault(); // Prevent the default tab behavior
            document.getElementById("ini").click(); // Trigger click on #nextPage
        }
    });
</script>
</div>
