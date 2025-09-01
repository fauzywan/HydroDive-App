<div>
    @if (session()->has('message'))
        <x-message-alert></x-message-alert>
    @endif
    <div class="flex flex-col justify-center items-center">

        <flux:navbar >
               @foreach ($navigations as $nav )
                    @if ($nav['no']==$navActive)
                    <flux:navbar.item  wire:click="show({{ $nav['no'] }})" current>{{ $nav['name'] }}</flux:navbar.item>
                    @else
                    <flux:navbar.item  wire:click="show({{ $nav['no'] }})" >{{ $nav['name'] }}</flux:navbar.item>
                    @endif
                @endforeach
        </flux:navbar>
    </div>
    <div class="grid relative grid-cols-1 sm:grid-cols-1  md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($events as $event)
        <x-card-event :event="$event" :user="auth()->user()"></x-card-event>
        @endforeach
        <div wire:loading class="absolute inset-0   flex justify-center items-center rounded-lg">
                <div class="flex justify-center items-center space-x-2 w-full h-full">
                <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
            <span class="text-blue-500">Memuat data...</span>
        </div>
        </div>
    </div>
{{--END  CARD --}}

</div>
