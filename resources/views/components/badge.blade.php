{{-- 
Componente Blade: <x-badge-type>

Scopo:
- Mostrare un badge colorato in base al tipo di annuncio (nuova, usata, noleggio)
- Usa un gradiente Tailwind dinamico
- Il contenuto del badge viene passato tramite {{ $slot }}
--}}

@php
    // Mappa dei gradienti in base al tipo di annuncio
    $colors = [
        'sale_new' => 'from-green-400 to-green-600', // Auto nuova
        'sale_used' => 'from-blue-400 to-blue-600', // Auto usata
        'rental' => 'from-yellow-400 to-yellow-600', // Noleggio
    ];
@endphp

<span
    class="px-3 py-1 text-sm font-semibold text-white rounded-full bg-gradient-to-r 
       {{ $colors[$type] ?? 'from-gray-400 to-gray-600' }}">
    {{ $slot }}
</span>
