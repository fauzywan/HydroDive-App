@props(['heat','isMatchActive'])
<flux:dropdown>
    <flux:button icon:trailing="chevron-down">...</flux:button>

    <flux:menu>
    @if ($isMatchActive==0)
    <flux:menu.item  icon="play" wire:click="createMatch('{{ $heat->id }}')">Heat Selanjutnya
    </flux:menu.item>
        @else
        <flux:menu.item  icon="play" wire:click="goToEventBerlangsung('{{ $heat->id }}')">Berlangsung
        </flux:menu.item>
    @endif
        <flux:menu.separator />

        <flux:menu.item  icon="pause" wire:click="pauseHeat('{{ $heat->id }}', '{{ $heat->branch->is_final }}')">Jeda Eventt
        </flux:menu.item>
        <flux:menu.separator />


        <flux:menu.item icon="flag" variant="danger" wire:click="EndtEvent('{{ $heat->id }}','{{  $heat->branch->administration->where('status',1)->count() }}')">Selesai
        </flux:menu.item>
    </flux:menu>
</flux:dropdown>
