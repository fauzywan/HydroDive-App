@props([
    'items',
    'active'
])
<flux:navbar>
    @foreach ($items as $item)
        @if ($item['no'] == $active)
            <flux:navbar.item wire:navigate href="{{ $item['href'] }}" current>
                {{ $item['name'] }}
            </flux:navbar.item>
        @else
            <flux:navbar.item wire:navigate href="{{ $item['href'] }}">
                {{ $item['name'] }}
            </flux:navbar.item>
        @endif
    @endforeach
</flux:navbar>
