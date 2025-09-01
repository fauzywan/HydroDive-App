<flux:navlist.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
<flux:navlist.item icon="identification" :href="route('parent-athlete.profile')" :current="request()->routeIs('parent-athlete.profile')" wire:navigate>{{ __('athlete') }}</flux:navlist.item>
