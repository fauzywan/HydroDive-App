<div>
    @if (session()->has('message'))

    <flux:callout icon="sparkles" color="green">
        <flux:callout.heading>Alert</flux:callout.heading>
        <flux:callout.text>
            {{ session('message') }}
        </flux:callout.text>
    </flux:callout>
    @endif

    <div class="flex w-full">

        <livewire:category.swimming-category-modal/>
        <div class="w-full flex justify-end">

            <flux:modal.trigger name="athlete-modal" id="th" >
                <flux:button icon="plus-circle" wire:click="refreshInput">Add Category</flux:button>
            </flux:modal.trigger>
        </div>
    </div>
    <div class="overflow-x-auto mt-5">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($swimmingCategory as $category)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{$swimmingCategory->firstItem()*$loop->iteration}}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $category->description }}</td>
                        <td class="px-6 py-2">

                                <flux:button icon="trophy" variant="primary" class="inline-flex items-center rounded-md cursor-pointer bg-yellow-400 px-2 py-1 text-xs font-medium text-yellow-900 inset-ring inset-ring-yellow-400/20"  wire:click="trophy({{ $category->id }})">Rank</flux:button>
                                <flux:button  icon="pencil" variant="primary" class="inline-flex items-center rounded-md cursor-pointer bg-blue-400 px-2 py-1 text-xs font-medium text-blue-900 inset-ring inset-ring-blue-400/20"  wire:click="edit({{ $category->id }})">Edit</flux:button>
                                <flux:button  icon="trash" variant="primary" class="inline-flex items-center rounded-md cursor-pointer bg-red-400 px-2 py-1 text-xs font-medium text-red-900 inset-ring inset-ring-red-400/20"  wire:click="delete({{ $category->id }})">Delete</flux:button>
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
    {{ $swimmingCategory->links() }}
</div>
