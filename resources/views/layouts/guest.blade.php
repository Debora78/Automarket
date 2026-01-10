{{-- 
Layout Blade: Pagina autenticazione (Login / Register) in stile Automarket

Props:
- title: titolo mostrato con effetto typewriter

Funzionalità:
- Struttura HTML completa con meta tag e CSRF token
- Caricamento asset tramite Vite
- Navbar e footer del progetto
- Contenuto centrato verticalmente con titolo animato
- Tema dark globale (sfondo nero + testo bianco)
--}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@props(['title' => ''])

<head>
    {{-- Meta principali --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Titolo --}}
    <title>{{ config('app.name', 'Automarket') }}</title>

    {{-- Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-black text-white">

    {{-- Navbar globale --}}
    <x-navbar />

    {{-- Contenuto principale (login/register) --}}
    <div class="min-h-screen flex flex-col items-center pt-28">
        <x-typewriter-title :text="$title" />

        {{ $slot }}
    </div>

    {{-- Footer --}}
    <x-footer />

</body>

</html>
