  @props(['eventBerlangsung'])

    @if($eventBerlangsung)
    <div class="bg-dark w-full flex justify-between items-center p-3 border-1 border-gray-50 rounded-lg">
        <div class="text">
             Berlangsung: <span class="text-white">{{ $eventBerlangsung->branch->eventNumber->category->description }}</span>
        </div>
        <flux:button icon="play" wire:click="GoToActiveEvent('{{ $eventBerlangsung->id }}')" class="text-white cursor-pointer">Masuk </flux:button>
    </div>
    @endif
