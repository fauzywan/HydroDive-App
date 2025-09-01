<div class="flex">
    <flux:modal name="athlete-modal" class="md:w-full " >
        <form class="overflow-hidden" wire:submit="{{$this->formType}}">
            <div class=" mb-5 w-[300%] flex md:gap-[5em] sm:gap-[2em] justif-center trans transition  duration-300 ease-in-out items-center"style=" transform:translateX(-{{$formStage*34}}%)">
            <div class="first-stage w-full ml-[2em] flex flex-col gap-5" id="firstStage">
                <flux:field>
                    <flux:label>Event Type</flux:label>
                    <flux:select wire:model="relay" placeholder="Choose Type..." wire:change="changeType">
                        <flux:select.option value="0">Individual</flux:select.option>
                        <flux:select.option value="1">Relay</flux:select.option>
                    </flux:select>
                    <flux:error name="gender" />
                </flux:field>
                @if ($selectedType==0)

                <flux:input label="Disntance (M)" placeholder="50" wire:model="distance" />
                @else
                 <div class="grid grid-cols-2 gap-2">
                    <flux:input icon="at-symbol" label="Person" type="text" wire:model="length" />
                    <flux:input icon="at-symbol" label="Distance (M)" type="text" wire:model="distance" />
                </div>
                @endif
                <flux:input label="Style" placeholder="FreeStyle" wire:model="style" />
                <flux:field>
                    <flux:label>Gender</flux:label>
                    <flux:select wire:model="gender" placeholder="Choose Gender...">
                        <flux:select.option value="man" selected>Man</flux:select.option>
                        <flux:select.option value="woman">Woman</flux:select.option>
                        <flux:select.option value="mix">Mix</flux:select.option>
                    </flux:select>
                    <flux:error name="gender" />
                </flux:field>

            <flux:input label="Pool Type" placeholder="LCM" wire:model="pool_type" />


            </div>
            <div class="second-stage w-full">
                <div class="preview-label">
                    <flux:heading>Distance</flux:heading>
                    <flux:text class="mt-2">{{ $distanceIs==''?'Not Filled':$distanceIs }}</flux:text>
                    <flux:error name="name" />
                </div>
                <div class="preview-label">
                    <flux:heading>Style</flux:heading>
                    <flux:text class="mt-2">{{ $style==''?'Not Filled':$style }}</flux:text>
                    <flux:error name="name" />
                </div>
                <div class="preview-label">
                    <flux:heading>Gender</flux:heading>
                    <flux:text class="mt-2">{{ $gender==''?'Not Filled':$gender }}</flux:text>
                    <flux:error name="name" />
                </div>
                <div class="preview-label">
                    <flux:heading>Pool Type</flux:heading>
                    <flux:text class="mt-2">{{ $pool_type==''?'Not Filled':$pool_type }}</flux:text>
                    <flux:error name="name" />
                </div>
                <div class="preview-label">
                    <flux:heading>Event Type</flux:heading>
                    <flux:text class="mt-2">{{ $relay==1?'Relay':'Individual' }}</flux:text>
                    <flux:error name="name" />
                </div>


                            </div>
            <div class="third-stage w-full"></div>
        </div>
            <div class="flex mt-2 flex gap-5 mr-2">
                <flux:spacer />
                @if($formStage>0)
                <flux:button class="cursor-pointer" type="button" wire:click="prevForm">{{ $prevButton }}</flux:button>
                @endif
                <flux:button id="ini" class="cursor-pointer" type="{{ $formStage==1?'submit':'button' }}" variant="primary"  wire:click="{{ $formStage==1?'':'nextForm' }}">{{ $nextButton }}</flux:button>
        </div>
    </form>
</flux:modal>

{{-- MODAL DELETE --}}


<flux:modal name="delete-profile" class="min-w-[22rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Delete Category?</flux:heading>

            <flux:text class="mt-2">
                <p>You're about to delete this</b></p>
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
<script>
document.getElementById('goToNext').addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            e.preventDefault(); // Prevent the default tab behavior
            document.getElementById("ini").click(); // Trigger click on #nextPage
        }
    });
</script>
</div>
