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

    </div>

    <x-club-index-navitation :waitingCount="$waitingCount"></x-club-index-navitation>
    <div class="overflow-x-auto mt-5 relative">

        <table id="clubes" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($waitingList as $wl)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $waitingList->firstItem() + $loop->index }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $wl->club->name}}</td>

                        <td class="px-6 py-2">
                            @if($wl->status==0)
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-600 ring-1 ring-blue-500/10 ring-inset">Approved</span>
                            @elseif($wl->status==2)
                            <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-600 ring-1 ring-red-500/10 ring-inset">Rejected</span>
                            @else
                            <span class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-600 ring-1 ring-yellow-500/10 ring-inset">Pending</span>
                            @endif

                        </td>
                        <td class="px-6 py-2">
                            @if($wl->status==1)
                            <flux:button variant="primary" wire:click="confirm({{ $wl->id }})">confirm</flux:button>
                            @endif
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
        {{-- {{ $clubes->links() }} --}}
    </div>
    <flux:modal name="delete-profile" class="md:w-full ">
        <form class="overflow-hidden" wire:submit="save">
            @if($formStage==0)
            <div class="preview-label">
                <flux:heading>Club Name</flux:heading>
                <flux:text class="mb-2">{{ $clubName==''?'Not Filled':$clubName }}</flux:text>
            </div>
            <div class="preview-label">
                <flux:heading>Club Email</flux:heading>
                <flux:text class="mb-2">{{ $clubEmail==''?'Not Filled':$clubEmail }}</flux:text>
            </div>
            <div class="preview-label">
                <flux:heading>Club Owner</flux:heading>
                <flux:text class="mb-2">{{ $clubOwner==''?'Not Filled':$clubOwner }}</flux:text>
            </div>
            <div class="preview-label">
                <flux:heading>Head Of Coach</flux:heading>
                <flux:text class="mb-2">{{ $clubHOC==''?'Not Filled':$clubHOC }}</flux:text>
            </div>
            <div class="preview-label">
                <flux:heading>Pool Place</flux:heading>
                <flux:text class="mb-2">{{ $clubPool==''?'Not Filled':$clubPool }}</flux:text>
            </div>
            <div class="preview-label">
                <flux:heading>Club Address</flux:heading>
                <flux:text class="mb-2">{{ $clubAddress==''?'Not Filled':$clubAddress }}</flux:text>
            </div>
            <div class="preview-label">
                <flux:heading>Number of Member</flux:heading>
                <flux:text class="mb-2">{{ $clubMember==''?'Not Filled':$clubMember }}</flux:text>
            </div>

            <div class="preview-label">
                <flux:heading>Logo</flux:heading>
                @if ($clubLogo)
                <img src="{{ asset("storage/club/$clubLogo") }}" class="rounded-full w-[200px] h-[200px] object-cover">
                @endif
            </div>
            <div class="preview-label">
                <flux:heading>Registration Payment</flux:heading>
                {{ $clubPayment==0?"Lunas":'Belum Lunas' }}
            </div>
            @elseif($formStage==1)
            <flux:select wire:change="rejectedClub" wire:model="approval" label="Club Approval">
                <flux:select.option value="1">Approved </flux:select.option>
                <flux:select.option value="0">Rejected</flux:select.option>
            </flux:select>
            @if($selectClub==0)
                <flux:textarea
                label=" Message"
                placeholder="..."
                wire:model="message"
                />

                @endif
            @endif




            <div class="flex mt-2 flex gap-5 mr-2">
                <flux:spacer />
                @if($formStage>0)
                <flux:button class="cursor-pointer" type="button" wire:click="prevForm">{{ $prevButton }}</flux:button>
                @endif
                <flux:button id="ini" class="cursor-pointer" type="{{ $formStage==1?'submit':'button' }}" variant="primary"  wire:click="{{ $formStage==2?'':'nextForm' }}">{{ $nextButton }}</flux:button>
        </div>

    </form>
</flux:modal>
<script>
    document.getElementById('goToNext').addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                e.preventDefault(); // Prevent the default tab behavior
                document.getElementById("ini").click(); // Trigger click on #nextPage
            }
        });
    </script>
</div>
