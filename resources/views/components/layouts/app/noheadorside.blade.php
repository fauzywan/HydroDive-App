
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
    <head>
        {{-- <script src="https://cdn.tailwindcss.com"></script> --}}

        @include('partials.head')
    </head>
    <body class="min-h-screen ">
        <div class="flex">


            {{ $slot }}
        </div>

        @fluxScripts
    </body>
</html>
