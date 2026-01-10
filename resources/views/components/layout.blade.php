{{-- 
Layout principale dell’applicazione (Master Layout)

Struttura:
- Include head con meta tag, Vite, Alpine.js e Livewire
- Navbar in alto e footer in basso
- Slot centrale per il contenuto delle pagine
- Tema dark globale con testo bianco
- Favicon e titolo dinamico

Utilizzo:
    <x-layout>
        ...contenuto pagina...
    </x-layout>
--}}

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    {{-- Meta tag principali --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- CSS e JS compilati da Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js per interattività leggera --}}
    <script src="//unpkg.com/alpinejs" defer></script>

    {{-- Script personalizzati --}}
    <script src="{{ asset('js/custom.js') }}"></script>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">

    {{-- Titolo dinamico della pagina --}}
    <title>{{ $title ?? 'AutoMarket' }}</title>

    {{-- Stili Livewire --}}
    @livewireStyles
</head>

<body class="bg-gray-900 text-white min-h-screen w-full">

    {{-- Navbar globale --}}
    <x-navbar />

    {{-- Contenuto dinamico della pagina --}}
    {{ $slot }}

    {{-- Footer globale --}}
    <x-footer />

    {{-- Script Livewire --}}
    @livewireScripts
</body>

</html>
