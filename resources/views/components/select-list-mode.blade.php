@props(['type'])

<div class="flex justify-end items-end">
  <flux:button.group>
    <flux:button
    type="button"
    variant="primary"
    class="{{ $type == 'list' ? 'bg-gray-600 text-white' : '' }}"
    wire:click="setViewMode('list')"
    >
    <svg


    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mx-auto cursor-pointer" fill="none"
    viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
    d="M4 6h16M4 12h16M4 18h16"/>
</svg>
    </flux:button>
    <flux:button
    variant="primary"
    class="{{ $type != 'list' ? 'bg-gray-600 text-white' : '' }}"
    type="button"
        wire:click="setViewMode('card')"
    >
           <svg

      xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mx-auto cursor-pointer" fill="none"
           viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 5h6M9 3h6a2 2 0 012 2v1H7V5a2 2 0 012-2zm9 6H6a2 2 0 00-2 2v7a2 2 0 002 2h12a2 2 0 002-2v-7a2 2 0 00-2-2z" />
      </svg>
    </flux:button>
</flux:button.group>
</div>
