<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    <title>{{ $title ?? 'AutoMarket' }}</title>
</head>

<body class="bg-gray-900 text-white min-h-screen w-full">

    <x-navbar />

    {{ $slot }}

    <x-footer />
</body>

</html>
