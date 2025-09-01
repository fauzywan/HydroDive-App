<flux:navlist.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
<flux:navlist.item icon="layout-grid" :href="route('athlete.guardians')" :current="request()->routeIs('athlete.guardians')" wire:navigate>{{ __('Wali') }}</flux:navlist.item>
<flux:navlist.item icon="layout-grid" :href="route('athlete.my-club')" :current="request()->routeIs('athlete.my-club')" wire:navigate>{{ __('Clubs') }}</flux:navlist.item>
<flux:navlist.item icon="layout-grid" :href="route('athlete.my-match')" :current="request()->routeIs('athlete.my-match')" wire:navigate>{{ __('Event Saya') }}</flux:navlist.item>
