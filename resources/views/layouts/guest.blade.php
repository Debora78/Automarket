<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Automarket') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-black text-white">

    <!-- Navbar del progetto -->
    <x-navbar />



    <!-- Contenuto della pagina (login/register) -->
    <div class="min-h-screen flex flex-col items-center  pt-28 ">
        <x-typewriter-title text="Accedi per viaggiare in Automarket" />

        {{ $slot }}
    </div>

</body>

</html>
