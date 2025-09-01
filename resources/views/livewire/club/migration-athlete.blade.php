<div>
@if (session()->has('message'))
    <flux:callout icon="sparkles" color="green">
        <flux:callout.heading>Alert</flux:callout.heading>
        <flux:callout.text>
            {{ session('message') }}
        </flux:callout.text>
    </flux:callout>
@endif

    <flux:navbar class="mb-5">
            @foreach ($navigations as $nav)
                @if ($nav['no'] == $navActive)
                    <flux:navbar.item wire:click="show({{ $nav['no'] }})" current>{{ $nav['name'] }}</flux:navbar.item>
                @else
                    <flux:navbar.item wire:click="show({{ $nav['no'] }})">{{ $nav['name'] }}</flux:navbar.item>
                @endif
            @endforeach
        </flux:navbar>
@if($navActive==1)
  <div class="overflow-x-auto mt-5 relative">
        <table id="athletes" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">nama</th>
                    <th scope="col" class="px-6 py-3">Club</th>
                    <th scope="col" class="px-6 py-3">Detail</th>
                    <th scope="col" class="px-6 py-3">Konfirmasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($migrations as $migration)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $migration->athlete->name() }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $migration->clubsMigration() }}</td>
                         <td>
                             <flux:badge color="blue" icon="information-circle"></flux:badge>
                        </td>
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                            <flux:button icon="check-circle" variant="primary" class="bg-green-600 text-white" wire:click="confirmMigration('{{ $migration->id }}',1)">
                                Terima
                            </flux:button>
                            <flux:button icon="x-circle" variant="danger" class="text-white" wire:click="confirmMigration('{{ $migration->id }}',0)">
                                Tolak
                            </flux:button>
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
    <flux:modal name="confirm-modal" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Konfirmasi Aksi</flux:heading>

                <flux:text class="mt-2">
                    <p>Tekan tombol Ya untuk melanjutkan aksi</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="button" class="{{ $typeButton==1?'bg-green-600':'' }}" wire:click="Migration">Ya</flux:button>
            </div>
        </div>
    </flux:modal>
@elseif($navActive==2)
<div class="overflow-x-auto mt-5 relative">
        <table id="athletes" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">nama</th>
                    <th scope="col" class="px-6 py-3">Club</th>
                    <th scope="col" class="px-6 py-3">Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($migrations as $migration)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $migration->athlete->name() }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $migration->clubsMigration() }}</td>
                         <td>
                             <flux:badge color="blue" icon="information-circle"></flux:badge>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
@endif

</div>
