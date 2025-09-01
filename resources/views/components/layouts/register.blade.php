<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">

        <div class="bg-background flex flex-col items-center justify-center gap-6 p-6 md:p-5">
            {{ $slot }}
        </div>

        @fluxScripts
    </body>
</html>
