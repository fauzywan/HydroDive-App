<div>
    <flux:navlist.group :heading="__('Platform')" class="grid">
        <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
        <flux:navlist.group :active="request()->route('athlete.')" heading="Athlete" expandable :expanded="false">
            <flux:navlist.item icon="user" :href="route('athlete')" :current="request()->routeIs('athlete')" wire:navigate>{{ __('Daftar Athlete') }}</flux:navlist.item>
            <flux:navlist.item icon="user" :href="route('migration')" :current="request()->routeIs('migration')" wire:navigate>{{ __('Migrasi Athlete') }}</flux:navlist.item>
        </flux:navlist.group>
        <flux:navlist.item :href="route('coach.index')" icon="clipboard-document-check" :current="request()->routeIs('coach')" wire:navigate>{{ __('Pelatih') }}</flux:navlist.item>
        <flux:navlist.group :active="request()->route('coach.')" heading="Club" expandable :expanded="false">
            <flux:navlist.item :href="route('club.index')" :current="request()->routeIs('club')" wire:navigate>{{ __('Daftar Club') }}</flux:navlist.item>
            <flux:navlist.item :href="route('club.registerFeeList')" :current="request()->routeIs   ('club')" wire:navigate>{{ __('Administrasi Club') }}</flux:navlist.item>
            <flux:navlist.item :href="route('facility')" :current="request()->routeIs('facility')" wire:navigate>{{ __('Fasilitas') }}</flux:navlist.item>
        </flux:navlist.group>
        <flux:navlist.group :active="request()->route('Event.')" heading="Event" expandable :expanded="false">
            <flux:navlist.item icon="user" :href="route('admin-event')" :current="request()->routeIs('admin-event')" wire:navigate>{{ __('Daftar Event') }}</flux:navlist.item>
            <flux:navlist.item icon="user" :href="route('admin-event-administration')" :current="request()->routeIs('admin-event-administration')" wire:navigate>{{ __('Administration') }}</flux:navlist.item>
            <flux:navlist.item icon="user" :href="route('swimming-category')" :current="request()->routeIs('swimming-category')" wire:navigate>{{ __('Kategori') }}</flux:navlist.item>
            <flux:navlist.item icon="user" :href="route('event-history')" :current="request()->routeIs('event-history')" wire:navigate>{{ __('Histori') }}</flux:navlist.item>
            <flux:navlist.item icon="user" :href="route('group-age')" :current="request()->routeIs('group-age')" wire:navigate>{{ __('Kelompok Usia') }}</flux:navlist.item>
        </flux:navlist.group>
        <flux:navlist.item :href="route('blog.index')" icon="clipboard-document-check" :current="request()->routeIs('blog')" wire:navigate>{{ __('Blog') }}</flux:navlist.item>

    </flux:navlist.group>
</div>
