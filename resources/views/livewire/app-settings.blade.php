<div class="p-6">

@if (session()->has('message'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 1500)"
        x-show="show"
        x-transition
    >
        <flux:callout icon="sparkles" color="green">
            <flux:callout.heading>Berhasil</flux:callout.heading>
            <flux:callout.text>
                {{ session('message') }}
            </flux:callout.text>
        </flux:callout>
    </div>
@endif

    {{-- Navbar --}}
    <div class="flex justify-center mt-5 mb-10">
        <flux:navbar>
            <flux:navbar.item href="#" wire:click="show(1)">Registration Fee</flux:navbar.item>
            <flux:navbar.item href="#" wire:click="show(2)">Default Password</flux:navbar.item>
            <flux:navbar.item href="#" wire:click="show(3)">Payment Method</flux:navbar.item>
            <flux:navbar.item href="/landing-page-settings" wire:navigate>Landing Page</flux:navbar.item>
        </flux:navbar>
    </div>

    {{-- Form: Registration Fee --}}
    @if ($formShow === 1)
        <form wire:submit.prevent="setRegistrationFee" class="max-w-md mx-auto space-y-4">
            <flux:field>
                <flux:label>Registration Fee</flux:label>
                <flux:description>Biaya pendaftaran Club Baru (dalam rupiah)</flux:description>
                <flux:input wire:model="nominal" placeholder="Contoh: 100000" />
                <flux:error name="nominal" />
            </flux:field>

            <flux:button type="submit">Simpan Fee</flux:button>
        </form>

    {{-- Form: Default Password --}}
    @elseif ($formShow === 2)
    <form wire:submit.prevent="setDefaultPassword" class="max-w-md mx-auto space-y-4">
        <flux:field>
            <flux:label>Default Password</flux:label>
            <flux:description>Password awal yang digunakan saat pembuatan akun</flux:description>
            <flux:input wire:model="defaultPassword" type="text" placeholder="Contoh: default123" />
                <flux:error name="defaultPassword" />
            </flux:field>

            <flux:button type="submit">Simpan Password</flux:button>
        </form>
        @elseif ($formShow === 3)
          <div class="w-full">
                <div class="left-area flex flex-col gap-5">
                  <flux:button icon="plus-circle" wire:click="addPaymentMethod">Add Method</flux:button>
                        <table id="athletes" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">Address</th>
                                    <th scope="col" class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($club->payment_methods as $method)
                                <tr>
                                    <td scope="col" class="px-6 py-3">{{$method->pm->name}}</td>
                                    <td scope="col" class="px-6 py-3">{{$method->payment_address}}</td>
                                    <td scope="col" class="px-6 py-3">

                                        <flux:button variant="primary" wire:click="editMethod({{ $method->id }})">Edit</flux:button>
                                        <flux:modal.trigger name="delete-profile">
                                            <flux:button variant="danger" wire:click="deleteMethod({{ $method->id }})">Delete</flux:button>
                                        </flux:modal.trigger></td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
    @endif
<flux:modal name="modal-document" class="min-w-[22rem]">
                @if($modalType==1)
         <div class="space-y-6">
             <div>
                <flux:select wire:model.live="payment_method_select" label="Payment Method" wire:key="payment_method_select">
                        @foreach ($paymentMethods as $pm)
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
                @if($photoQr)
                @endif

            </div>

            <div class="flex gap-2">
                <flux:button type="button" wire:click="{{ $buttonType}}"
                wire:target="photoQr"
                wire:loading.attr="disabled"
                >Save</flux:button>
            </div>
        </div>
        @else
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
        @endif
    </flux:modal>
</div>
