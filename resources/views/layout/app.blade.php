<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">

    <div id="app" class="flex flex-col min-h-screen">
        {{-- Menú fijo arriba --}}
        @include('layout.menu')

        {{-- Contenido principal --}}
        <main class="flex-1">
            @yield('content')
        </main>
    </div>

</body>
</html>
