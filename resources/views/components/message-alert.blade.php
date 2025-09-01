@php
    $color = 'green';
    if (session()->has('type-message')) {
        $color = session('type-message');
    }
@endphp

@if (session()->has('message'))
    <div id="flash-message">
        <flux:callout icon="sparkles" color="{{ $color }}">
            <flux:callout.heading>Alert</flux:callout.heading>
            <flux:callout.text>
                {{ session('message') }}
            </flux:callout.text>
        </flux:callout>
    </div>

    <script>
        setTimeout(() => {
            const el = document.getElementById('flash-message');
            if (el) el.style.display = 'none';
        }, 1000);
    </script>
@endif
