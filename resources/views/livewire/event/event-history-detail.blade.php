<div>
    <div class="flex justify-between mb-4 no-print">
        <div>
            <flux:heading size="lg">Riwayat Event</flux:heading>
        </div>
        <div>
            <flux:select wire:model.live="dateSelect" class="px-2 py-2">
                @foreach ($eventDates as $date)
                    <flux:select.option value="{{ $date->id }}">
                        {{ date("d F Y",strtotime($date->competition_start)) }}
                    </flux:select.option>
                @endforeach
            </flux:select>
        </div>
    </div>

    <flux:navbar class="no-print">
        @foreach ($navigations as $nav )
            @if ($nav['no']==$navActive)
                <flux:navbar.item wire:click="show({{ $nav['no'] }})" current>{{ $nav['name'] }}</flux:navbar.item>
            @else
                <flux:navbar.item wire:click="show({{ $nav['no'] }})">{{ $nav['name'] }}</flux:navbar.item>
            @endif
        @endforeach
    </flux:navbar>

    {{-- ================= MENU 1 ================= --}}
    @if($this->navActive==1)
        <div class="flex justify-end mb-2 no-print">
            <flux:button type="button" onclick="printSection('print-area-1')" icon="printer">
                Print
            </flux:button>
        </div>

        <div class="overflow-x-auto mt-5 relative" id="print-area-1">
            <table id="athletes" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">#</th>
                        <th scope="col" class="px-6 py-3">Nomor</th>
                        <th scope="col" class="px-6 py-3">Lomba</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($event->numbers->whereBetween('created_at', [$this->dateStart, $this->dateEnd]) as $number)
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}</td>
                            <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $number->number }}</td>
                            <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $number->category->description }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    {{-- ================= MENU 2 ================= --}}
    @elseif($this->navActive==2)
        <div class="flex justify-end mb-2 no-print">
            <flux:button type="button" onclick="printSection('print-area-2')" icon="printer">
                Print
            </flux:button>
        </div>

        <div id="print-area-2">
            @foreach ($event->branches->whereBetween('created_at', [$this->dateStart, $this->dateEnd]) as $branch)
                <p class="mb-2">Nomor: {{$branch->eventNumber->number}} - Lomba: {{$branch->eventNumber->category->description}}</p>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mb-4">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">Peringkat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($branch->administration->whereBetween('created_at', [$this->dateStart, $this->dateEnd])->sortBy('rank') as $a)
                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}</td>
                                <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $a->athlete->name() }}</td>
                                <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $a->rank}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        </div>

    {{-- ================= MENU 3 ================= --}}
    @elseif($this->navActive==3)
        <div class="flex justify-end mb-2 no-print">
            <flux:button type="button" onclick="printSection('print-area-3')" icon="printer">
                Print
            </flux:button>
        </div>

        <div class="overflow-x-auto mt-5 relative" id="print-area-3">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Nama</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clubs as $club)
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}</td>
                            <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $club->club->id==1?"Federasi":$club->club->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    {{-- ================= MENU 5 (Match) ================= --}}
    @elseif($this->navActive==5)
        <div class="flex justify-end mb-2 no-print">
            <flux:button type="button" onclick="printSection('print-area-5')" icon="printer">
                Print
            </flux:button>
        </div>

        <div id="print-area-5">
            @foreach ($Matches as $m)
                <p class="mx-2">{{ $m->name }}</p>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mb-4">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">Peringkat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($m->player->sortBy('rank') as $player)
                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}</td>
                                <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $player->athlete->name() }}</td>
                                <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $player->rank }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        </div>
    @endif
</div>

{{-- SCRIPT PRINT --}}
@livewireScripts
<script>
function printSection(sectionId) {
    var content = document.getElementById(sectionId).innerHTML;
    var mywindow = window.open('', 'PRINT', 'height=600,width=800');

    mywindow.document.write('<html><head><title>Print</title>');
    mywindow.document.write('<style>@media print {.no-print{display:none;} table{width:100%;border-collapse:collapse;} th,td{border:1px solid #000;padding:6px;}}</style>');
    mywindow.document.write('</head><body>');
    mywindow.document.write(content);
    mywindow.document.write('</body></html>');

    mywindow.document.close();
    mywindow.focus();
    mywindow.print();
    mywindow.close();
}
</script>

<style>
@media print {
    .no-print {
        display: none !important;
    }
}
</style>
