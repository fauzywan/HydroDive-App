<div>

    @if (session()->has('error') )

    <flux:callout icon="sparkles" color="red">
        <flux:callout.heading>Alert</flux:callout.heading>
        <flux:callout.text>
            {{ session('error') }}
        </flux:callout.text>
    </flux:callout>
    @endif
    @if (session()->has('message') )

    <flux:callout icon="sparkles" color="green">
        <flux:callout.heading>Alert</flux:callout.heading>
        <flux:callout.text>
            {{ session('message') }}
        </flux:callout.text>
    </flux:callout>
 
    @endif
    <div class="overflow-x-auto mt-5 relative">
        <table id="athletes" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Amount</th>
                    <th scope="col" class="px-6 py-3">Remaining Amount</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($athletes as $registration)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}</td>
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $registration->athlete->name() }}</td>
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $registration->amount }}</td>
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $registration->remaining_amount }}</td>
                        <td class="px-6 py-2">
                            <flux:button class="text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800" type="button" variant="primary" id="ini" wire:click="pay({{ $registration->id }})">Pay</flux:button>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div wire:loading >
            <div class=" w-full flex justify-center items-center absolute top-0 left-0 right-0 bottom-0 z-50">

                <flux:icon.loading />
            </div>
        </div>
    </div>
    <div class="mt-5">
        {{-- {{ $athletes->links() }} --}}
    </div>
    {{-- MODAL DELETE --}}


    <flux:modal name="pay-athlete" class="w-full text-center">
        <form wire:submit="payAthlete">

            <flux:input wire:model="athlete_name" placeholder="athlete Name" label="Athlete" readonly/>
            <flux:input wire:model="athlete_money" placeholder="1000" label="Nominal" class="mb-2"/>
            <flux:input wire:model="athlete_money_date" type="date"  label="Date" class="mb-2"/>
            <flux:modal.close>
                <flux:button variant="ghost" class="mt-5">Cancel</flux:button>
            </flux:modal.close>

            <flux:button type="submit">Save</flux:button>
        </form>
</flux:modal>

</div>
