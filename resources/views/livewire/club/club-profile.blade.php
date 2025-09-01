<div>

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
                <img src="{{ $club->logo==null?asset("storage/default.jpg"):asset("storage/club/$club->logo") }}" alt="" class="rounded-full w-[250px] h-[250px] object-cover">
                <svg x-on:click="document.getElementById('pot2').click()"  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 28 25" stroke-width="1.5" stroke="#333" class="bg-white rounded border-2 border-solid p-1 size-10 rounded-full absolute right-5 bottom-4  text-gray-500 hover:text-gray-700 cursor-pointer">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                    </svg>
                </div>
                <div class="flex flex-col items-center">
                    <flux:heading size="lg">{{ $club->name}}</flux:heading>
                    <flux:text class="">
                        <p>{{$club->email}}</p>
                    </flux:text>
                </div>
                    <flux:button icon="plus-circle" wire:click="edit({{$club->id }})" class="w-full">Edit Profile</flux:button>
            </div>
        </div>
        <div class="col-span-4 md:col-span-3 relative ">
            <div  wire:loading wire:target="photo" >
                <div class="absolute right-0 left-0 bottom-0 top-0  flex justify-center items-center">
                    <x-loader/>
                </div>
            </div>

            <flux:navbar >
                <flux:navbar.item wire:click="show(1)">Profile</flux:navbar.item>
                <flux:navbar.item wire:click="show(2)">Documents</flux:navbar.item>
                <flux:navbar.item wire:click="show(3)">Membership</flux:navbar.item>
                  @if (auth()->user()->role_id==1)
                <flux:navbar.item wire:click="show(5)">Facilities</flux:navbar.item>
                <flux:navbar.item wire:click="show(4)">Athlete</flux:navbar.item>
                @endif
                <flux:navbar.item wire:click="show(6)">Payment</flux:navbar.item>
            </flux:navbar>
            <div wire:loading wire:target="show">
                <div class="absolute right-0 left-0 bottom-0 top-0 flex justify-center items-center">
                    <flux:icon.loading />
                </div>
            </div>
        @if($formShow==1)
        <div class="grid grid-cols-2 ">
            <div class="preview-label">
                <flux:heading>Name</flux:heading>
                <flux:text class="mb-2">{{ $club->name==''?'Belum Diisi':$club->name }}({{ $club->nick }})</flux:text>
            </div>
            <div class="preview-label">
                <flux:heading>Club Type</flux:heading>
                <flux:text class="mb-2">{{ $club->type->name==''?'Belum Diisi':$club->type->name }}</flux:text>
            </div>
            <div class="preview-label">
                <flux:heading>Email</flux:heading>
                <flux:text class="mb-2">{{ $club->email==''?'Belum Diisi':$club->email }}</flux:text>
            </div>
            <div class="preview-label">
                <flux:heading>Owner</flux:heading>
                <flux:text class="mb-2">{{ $club->owner==''?'Belum Diisi':$club->owner }}</flux:text>
            </div>
            <div class="preview-label">
                <flux:heading>Head Of Coach</flux:heading>
                <flux:text class="mb-2">{{ $club->head==''?'Belum Diisi':$club->head->name }}</flux:text>
            </div>

            <div class="preview-label">
                <flux:heading>Club Address</flux:heading>
                <flux:text class="mb-2">{{ $club->address==''?'Belum Diisi':$club->address }}</flux:text>
            </div>
            <div class="preview-label">
                <flux:heading>Member of Club</flux:heading>
                <flux:text class="mb-2">{{ $club->athletes==''?'Belum Diisi':$club->athletes->count() }} Athlete</flux:text>
            </div>
            </div>
            @elseif($formShow==6)
             <div class="grid grid-cols-2 ">
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

                                        <flux:modal.trigger name="delete-profile">
                                            <flux:button variant="danger" wire:click="deleteMethod({{ $method->id }})">Delete</flux:button>
                                        </flux:modal.trigger></td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @elseif($formShow==5)


                        @if($facilities->count()==0)
                <flux:callout icon="sparkles" color="green">
            <flux:callout.heading>Alert</flux:callout.heading>
            <flux:callout.text>
                {{ 'No Facilities Found' }}
            </flux:callout.text>
        </flux:callout>
            @endif
            <div class="flex flex-col justify-center items-center">

                        <table id="athletes" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($facilities as $f)
                                <tr>
                                    <td scope="col" class="px-6 py-3">{{$f->name}}</td>
                                    <td scope="col" class="px-6 py-3">
                                        @if($f->status==1)
                                        Dimiliki
                                        @elseif($f->status==2)
                                        Sewa
                                        @else
                                        Umum
                                        @endif
                                    </td>
                                    <td scope="col" class="px-6 py-3">
                                    <a href="{{ asset("storage/club/facility/$f->photo") }}" download>download</a>
                                            <flux:button
                                            wire:click="imageFacility({{ $f->id }})">Detail</flux:button>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


            @if($modalStatus==1)
            <div id="iniHidden" class=" fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
                <div class="bg-white p-4 rounded-lg shadow-lg max-w-[90%] max-h-[90%] relative">
                    <!-- Tombol Close -->
                    <button onclick="document.querySelector('#iniHidden').classList.add('hidden')" wire:click="modalStatusChange(0)" class="absolute cursor-pointer top-2 right-2 text-gray-600 hover:text-red-600 transition duration-200 rounded-full p-1 hover:bg-red-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    <img src="{{ asset($srcPreview) }}" alt="Zoomed Image" class="max-w-full max-h-[80vh] object-contain" />
        </div>
    </div>
                @endif
            @elseif($formShow==4)
            @if($club->athletes->count()!=0)
             <table id="athletes" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">City</th>
                                    <th scope="col" class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($club->athletes as $athlete)
                                <tr>
                                    <td scope="col" class="px-6 py-3">{{$athlete->first_name." ".$athlete->last_name}}</td>
                                    <td scope="col" class="px-6 py-3">{{$athlete->city}}</td>
                                    <td scope="col" class="px-6 py-3">
                                        <flux:button class="text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800" type="button" variant="primary" id="ini" href="athlete/{{$athlete->id}}/profile">Detail</flux:button>

                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <flux:callout icon="sparkles" color="green">
                            <flux:callout.heading>Alert</flux:callout.heading>
                            <flux:callout.text>
                                {{ 'No Athlete Found' }}
                            </flux:callout.text>
                        </flux:callout>
                        @endif
            @elseif($formShow==2)
            <div class="grid grid-cols-2 ">

            <div class="left-area flex flex-col gap-5">
                <flux:button icon="plus-circle" wire:click="addDocument">Add Document</flux:button>

                        <table id="athletes" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">file</th>
                                    <th scope="col" class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($documents as $d)
                                <tr>

                                    <td scope="col" class="px-6 py-3">{{$d->name}}</td>

                                    <td scope="col" class="px-6 py-3">
                                    <a href="{{ asset("storage/club/document/$d->filename") }}" download>download</a>
                                        <flux:modal.trigger name="delete-profile">
                                            <flux:button variant="danger" wire:click="delete({{ $d->id }})">Delete</flux:button>
                                        </flux:modal.trigger></td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @elseif($formShow==3)
                <div class="">
                    <div class="flex-col flex justify-center items-center">
                        <img src="{{ $club->logo==''?asset("default.jpg"):asset("storage/club/$club->logo") }}" alt="" class="rounded-full w-[100px] h-[100px] object-cover">
                        <x-auth-header :title="__($club->name)" :description="__() " />
                            @if ($club->status==1)
                            <div class="w-[30%] mx-2">

                                <flux:callout icon="check-badge" color="green">
                                    <flux:callout.text class="text-center">
                                        Part Of Akuatik Indonesia
                                    </flux:callout.text>
                                </flux:callout>
                            </div>
                            {{-- Tombol download sertifikat --}}
                            <div class="mt-3">
                                <a href="{{ route('club.certificate.download', $club->id) }}" >
                                    <flux:button variant="primary" class="cursor-pointer">Download Certificate</flux:button>
                                </a>
                            </div>
                               @if (auth()->user()->role_id==1)
                                <flux:button wire:click="removeMembershipModal" class="cursor-pointer" variant="danger">Remove Member</flux:button>
                            @endif


                            @else
                            @if (auth()->user()->role_id==1)
                            <form wire:submit="addMembership" class="mt-2">
                                <flux:button type="submit" class="cursor-pointer">add Member</flux:button>
                            </form>
                            @endif
                            <flux:text class="font-bold">Not Part Of Akuatik Indonesia'</flux:text>
                            @endif
                            @if(auth()->user()->role_id==5 && $club->status==0)
                            {{-- @if (($waitingList->count() >0 && $club->status!=0 )|| $waitingList->count()==0 || ($waitingList->count()>0 && $waitingList->where('status',2)->count()>0 && $club->status==0 && $waitingList->where('status',1)->count()==0)) --}}
                            @if ($club->status==0 && $waitingList->where('status',1)->count()==0)
                            <form wire:submit="requestMembership" class="mt-2">
                                <flux:button type="submit" class="cursor-pointer">Request Membership</flux:button>
                            </form>
                            @endif

                            {{-- @endif --}}
                            @endif
                        </div>

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
        @endif
    </div>
   <x-club-profile-modal></x-club-profile-modal>
    </div>
</div>


