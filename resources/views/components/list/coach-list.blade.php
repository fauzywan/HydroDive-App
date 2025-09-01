<flux:navlist.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
<flux:navlist.item icon="calendar-days" :href="route('coach.schedule')" :current="request()->routeIs('coach.schedule')" wire:navigate>{{ __('schedule') }}</flux:navlist.item>
<flux:navlist.item icon="identification" :href="route('coach.license')" :current="request()->routeIs('coach.license')" wire:navigate>{{ __('license') }}</flux:navlist.item>
