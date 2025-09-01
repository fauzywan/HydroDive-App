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
<div class="">
    <div class="flex-col flex justify-center items-center">
        <img src="{{ $club->logo==''?asset("default.jpg"):asset("storage/club/$club->logo") }}" alt="" class="rounded-full w-[100px] h-[100px] object-cover">
        <x-auth-header :title="__($club->name)" :description="__() " />
            @if ($club->status==1)
            <div class="w-[30%] ">

                <flux:callout icon="check-badge" color="green">
                    <flux:callout.text class="text-center">
                        Part Of Akuatik Indonesia
                    </flux:callout.text>
                </flux:callout>
            </div>
            @else
            <flux:text class="font-bold">Not Part Of Akuatik Indonesia'</flux:text>
            @endif
    </div>

    @if ($waitingList->count()==0 || ($waitingList->count()>0 && $waitingList->where('status',2)->count()>0 && $club->status==0 &&$waitingList->where('status',1)->count()==0))
    <form wire:submit="requestMembership" class="mt-2">
        <flux:button type="submit" class="cursor-pointer">Request Membership</flux:button>
    </form>

    @endif
    @if($club->status!=1)
    <table id="athletes" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-5">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Date</th>
                <th scope="col" class="px-6 py-3">status</th>
                <th scope="col" class="px-6 py-3">Message</th>
                <th scope="col" class="px-6 py-3">Approver</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($waitingList as $wl)
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                        {{ $wl->created_at->diffForHumans() }}</td>
                    <td>   @if ($wl->status==1)
                        <span class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-600 ring-1 ring-yellow-500/10 ring-inset">Pending</span>
                        @elseif ($wl->status==2)
                        <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-600 ring-1 ring-red-500/10 ring-inset">Rejected</span>
                        @else
                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-600 ring-1 ring-green-500/10 ring-inset">Approved</span>
                        @endif</td>
                        <td>
                            @if ($wl->status==0)
                            Disetujui    
                            @elseif ($wl->status==1)
                            Sedang Dalam Peninjauan
                            @else
                            {{$wl->message}}
                            @endif

                        </td>
                        <td>{{$wl->Approver?$wl->Approver:'-'}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif


</div>
</div>
