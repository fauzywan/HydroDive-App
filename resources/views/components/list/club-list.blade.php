<flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('') }}</flux:navlist.item>

<flux:dropdown>
    <flux:navbar.item  icon="user-group" icon:trailing="chevron-down">Atlet</flux:navbar.item>
    <flux:navmenu>
        <flux:navlist.item :href="route('club.athlete')" :current="request()->routeIs('club.athlete')" wire:navigate>{{ __('List of Athlete') }}</flux:navlist.item>
        <flux:navlist.item  :href="route('club.administration')" :current="request()->routeIs('club.administration')" wire:navigate>{{ __('Administration') }}</flux:navlist.item>
        <flux:navlist.item  :href="route('club.migration')" :current="request()->routeIs('club.migration')" wire:navigate>{{ __('Migration Club') }}</flux:navlist.item>
    </flux:navmenu>
</flux:dropdown>
<flux:dropdown>
    <flux:navbar.item  icon="user-group" icon:trailing="chevron-down">Kompetisi</flux:navbar.item>
    <flux:navmenu>
        <flux:navlist.item icon="clipboard-document-check" :href="route('club.event')" :current="request()->routeIs('club.event')" wire:navigate>{{ __('Kompetisi') }}</flux:navlist.item>
        @if(auth()->user()->club->type->is_create==1)
        <flux:navlist.item icon="clipboard-document-check" :href="route('club.myEventAdministration')" :current="request()->routeIs('club.my-event-administration')" wire:navigate>{{ __('Administrasi Kompetisi') }}</flux:navlist.item>
        <flux:navlist.item icon="clipboard-document-check" :href="route('club.myEvent')" :current="request()->routeIs('club.my-event')" wire:navigate>{{ __('Kompetisi Saya') }}</flux:navlist.item>
        @endif
    </flux:navmenu>
</flux:dropdown>
<flux:navlist.item icon="clipboard-document-check" :href="route('club.coach')" :current="request()->routeIs('club.coach')" wire:navigate>{{ __('Pelatih') }}</flux:navlist.item>
<flux:navlist.item icon="building-office-2" :href="route('club.facility')" :current="request()->routeIs('club.facility')" wire:navigate>{{ __('Fasilitas') }}</flux:navlist.item>


<flux:navlist.item icon="calendar-days" :href="route('club.schedule')" :current="request()->routeIs('club.schedule')" wire:navigate>{{ __('Latihan') }}</flux:navlist.item>
<flux:navlist.item icon="banknotes" :href="route('club.myBill')" :current="request()->routeIs('club.myBill')" wire:navigatemp>{{ __('Tagihan') }}</flux:navlist.item>
<flux:navlist.item icon="clock" :href="route('event.matchtime')" :current="request()->routeIs('event.matchtime')" wire:navigatemp>{{ __('Stopwatch') }}</flux:navlist.item>


