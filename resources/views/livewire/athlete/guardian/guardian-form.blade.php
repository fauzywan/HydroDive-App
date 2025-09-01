<div>
    <x-auth-header :title="__('Guardian Athlete Registration Form')" :description="__('Add Athlete ')" />

    <div class="flex justify-center item-center w-full">
            <form   wire:submit="{{$formType}}" class="w-[50%]">
                <div class=" mb-5">

                    @if ($formStage == 1)

                    <div class="preview-label">
                        <flux:heading>Guardian Name</flux:heading>
                        <flux:text class="mt-2">{{ $name == '' ? 'Not Filled' : $name }}</flux:text>
                        <flux:error name="name" />
                    </div>

                    <div class="preview-label">
                        <flux:heading>Relation</flux:heading>
                        <flux:text class="mt-2">{{ $relation == '' ? 'Not Filled' : $relation }}</flux:text>
                        <flux:error name="relation" />
                    </div>

                    <div class="preview-label">
                        <flux:heading>Gender</flux:heading>
                        <flux:text class="mt-2">{{ $gender == '' ? 'Not Filled' : ucfirst($gender) }}</flux:text>
                        <flux:error name="gender" />
                    </div>

                    <div class="preview-label">
                        <flux:heading>Email</flux:heading>
                        <flux:text class="mt-2">{{ $email == '' ? 'Not Filled' : $email }}</flux:text>
                        <flux:error name="email" />
                    </div>

                    <div class="preview-label">
                        <flux:heading>Phone</flux:heading>
                        <flux:text class="mt-2">{{ $phone == '' ? 'Not Filled' : $phone }}</flux:text>
                        <flux:error name="phone" />
                    </div>

                    <div class="preview-label">
                        <flux:heading>Address</flux:heading>
                        <flux:text class="mt-2">{{ $address == '' ? 'Not Filled' : $address }}</flux:text>
                        <flux:error name="address" />
                    </div>
                    @elseif($formStage==0)
                    <div class="w-full">
                        <flux:input label="athlete name" placeholder="Athlete Name" wire:model="athlete_name" readonly />
                        <flux:input label="Name" placeholder="name" wire:model="name" />
                        <flux:input label="relation" placeholder="relation" wire:model="relation" />
                        <flux:select wire:model="gender" label="Gender" wire:key="{{ isset($athlete)?$athlete->gender:'female' }}">
                            <flux:select.option value="male">male</flux:select.option>
                            <flux:select.option value="female">female</flux:select.option>
                        </flux:select>
                        <flux:input label="email" placeholder="email" wire:model="email" />
                        <flux:input label="phone" placeholder="phone" wire:model="phone" />
                        <flux:textarea
                        label="Address"
                        placeholder="..."
                        wire:model="address"
                        />
                </div>
                @endif
            </div>
                <div class="flex mt-2 {{$formStage==1?'justify-center items-center':'justify-end'}} gap-5 mr-2">
                    @if($formStage>0)
                    <flux:button class="cursor-pointer" type="button" wire:click="prevForm">{{ $prevButton }}</flux:button>
                    @endif
                    <flux:button id="ini" class="cursor-pointer" type="{{ $formStage==1?'submit':'button' }}" variant="primary"  wire:click="{{ $formStage==2?'':'nextForm' }}">{{ $nextButton }}</flux:button>
            </div>

        </form>

    {{-- MODAL DELETE --}}


        <flux:modal name="delete-profile" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Delete Athlete?</flux:heading>

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
        {{-- MODAL DELETE --}}

    </div>

</div>
