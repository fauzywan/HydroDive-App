w<div>
  <flux:modal name="modal-document" class="min-w-[22rem]">
        @if($this->modalType==1)
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete Athlete?</flux:heading>

                <flux:text class="mt-2">
                    <p>You're about to delete <b>{{ $this->first_name }}</b></p>
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
        @elseif($this->modalType==4)
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete Athlete?</flux:heading>

                <flux:text class="mt-2">
                    <p>You're about to delete <b>{{ $this->first_name }}</b></p>
                    <p>This action cannot be reversed.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="button" wire:click="destroyMethod" variant="danger">Delete Athlete</flux:button>
            </div>
        </div>
        @elseif($this->modalType==2)
        <div class="space-y-6">
            <div>
                <flux:heading size="lg"> Club Document</flux:heading>
                <flux:input type="file" wire:model="file" label="Document"/>
                @if($this->file)
                <flux:input type="text" wire:model="fileName" label="Document Name"/>
                @endif

            </div>
            <div class="flex gap-2">
                <flux:button type="button" wire:click="uploadDocument"
                wire:target="file"
                wire:loading.attr="disabled"
                >Upload Document</flux:button>
            </div>
        </div>
        @elseif($this->modalType==3)
         <div class="space-y-6">
             <div>
                <flux:select wire:model.live="payment_method_select" label="Payment Method" wire:key="payment_method_select">
                    @foreach ($this->paymentMethods as $pm)
                    <flux:select.option value="{{ $pm->id }}">{{$pm->name}}</flux:select.option>
                    @endforeach
                    <flux:select.option value="0">Other</flux:select.option>
                </flux:select>
                @if($this->payment_method_select==0)
                    <flux:input class="mt_2" label="Nama Method" wire:model="payment_method_input" />
                    @endif
                </div>
                <div>
                    <flux:input class="mt_2" label="Nomor" wire:model="payment_method_address" />
                </div>
            <div>
                <flux:input type="file" wire:model="photoQr" label="Qr Code (Jika ada)"/>
                @if($this->photoQr)
                @endif

            </div>
            <div class="flex gap-2">
                <flux:button type="button" wire:click="newMethod"
                wire:target="photoQr"
                wire:loading.attr="disabled"
                >Save</flux:button>
            </div>
        </div>
        @endif
    </flux:modal>
      <flux:modal name="remove-membership" class="md:w-full ">
        <form class="overflow-hidden" wire:submit="removeMembership">

                <flux:textarea
                label=" Message"
                placeholder="..."
                wire:model="message"
                />
            <div class="flex mt-2 flex gap-5 mr-2">
                <flux:spacer />

                <flux:button id="ini" type="submit" class="cursor-pointer" >Save</flux:button>
            </div>
    </form>
</flux:modal>

    <flux:modal name="edit-profile" class="min-w-[22rem]" >
        <div class="space-y-6 flex justify-center items-center w-full
        flex-col">
        <form wire:submit="updateUserProfile" class="flex flex-col justify-center items-center">
            @if ($this->photo)
            <img src="{{ $this->photo->temporaryUrl() }}" alt="" class="rounded-full w-[250px] h-[250px] object-cover">
            @endif
            <input type="file" id="pot2" wire:model="photo">


            <div class="flex gap-2">
                <flux:spacer />


                <flux:button  x-on:click="document.getElementById('pot2').click()"  class="mt-5">Ubah</flux:button>
                <flux:button type="submit" class="mt-5" wire:loading.attr="disabled"

            wire:target="photo" >Upload File</flux:button>
            </form>

            </div>
        </div>
    </flux:modal>
</div>
