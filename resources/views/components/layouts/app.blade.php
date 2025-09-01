
@if(auth()->user()==null)
<x-layouts.app.noheadorside :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts.app.noheadorside>
@else
@if (auth()->user()->role_id==3 ||  auth()->user()->role_id==4 || auth()->user()->role_id==5 || auth()->user()->role_id==2)
<x-layouts.app.header :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts.app.header>
@else

<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
@endif
@endif

