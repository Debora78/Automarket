{{-- 
Layout Blade predefinito (tipico di Laravel Breeze / Jetstream)

Funzionalità:
- Imposta struttura HTML base con meta tag, CSRF token e titolo dinamico
- Carica font Figtree da Bunny.net
- Include gli asset compilati da Vite (CSS + JS)
- Wrapper con background chiaro/scuro
- Include la navigation bar
- Se presente, mostra un header di pagina
- Slot centrale per il contenuto dinamico

Perfetto come layout principale per pagine interne dell’app.
--}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{-- Meta principali --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Titolo dinamico --}}
    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Assets compilati da Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

        {{-- Navbar --}}
        @include('layouts.navigation')

        {{-- Header opzionale --}}
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Contenuto principale --}}
        <main>
            {{ $slot }}
        </main>

    </div>
</body>

</html>
