<div>

    @if (session()->has('message'))

    <flux:callout icon="sparkles" color="green">
        <flux:callout.heading>Alert</flux:callout.heading>
        <flux:callout.text>
            {{ session('message') }}
        </flux:callout.text>
    </flux:callout>
    @endif
    <div class="w-full flex items-center justify-between">
    <div>
    </div>
        <flux:navbar>
            @foreach ($navigations as $nav )
            @if ($nav['no']==$navActive)
            <flux:navbar.item  wire:click="show({{ $nav['no'] }})" current>{{ $nav['name'] }}</flux:navbar.item>
            @else
            <flux:navbar.item  wire:click="show({{ $nav['no'] }})" >{{ $nav['name'] }}</flux:navbar.item>
            @endif
            @endforeach
        </flux:navbar>
        <flux:button href="user/add" icon="plus-circle">Add user</flux:button>
    </div>
    <flux:input type="text"  icon:trailing="magnifying-glass" wire:model.live.debounce.1000ms="keyword" placeholder="Cari Email"/>

    <div class="overflow-x-auto mt-5 relative">

        <table id="users" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Title</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $users->firstItem() + $loop->index }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $user->email}}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $user->role->name}}</td>
                        <td class="px-6 py-2">
                            <flux:button class="text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800" type="button" variant="primary" id="ini" wire:click="resetRequest({{ $user->id }})">Reset Password</flux:button>
                            <flux:button class="text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800" type="button" variant="primary" id="ini" wire:click="edit({{ $user->id }})">Edit</flux:button>
                           @if($user->role_id!=1)
                           <flux:button variant="danger" wire:click="delete({{ $user->id }})">Delete</flux:button>
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
        {{ $users->links() }}
    </div>

    <flux:modal name="edit-profile" class="min-w-[22rem]">
        <form wire:submit="update">
            <flux:field>
                <flux:label>Email</flux:label>
                <flux:input wire:model="email"/>
                <flux:error name="email" />
            </flux:field>
            <flux:button type="submit" class="mt-2">Save</flux:button>
        </form>
    </flux:modal>

    <flux:modal name="delete-profile" class="min-w-[22rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Delete user?</flux:heading>

            <flux:text class="mt-2">
                <p>{{$textModal}}<b>{{ $first_name }}</b></p>
                <p>This action cannot be reversed.</p>
            </flux:text>
        </div>

        <div class="flex gap-2">
            <flux:spacer />

            <flux:modal.close>
                <flux:button variant="ghost">Cancel</flux:button>
            </flux:modal.close>

            <flux:button type="button" wire:click="{{$modalDelete}}" variant="danger">{{$modalButton}}</flux:button>
        </div>
    </div>

</flux:modal>
</div>
