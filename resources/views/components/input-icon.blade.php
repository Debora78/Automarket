{{-- 
Componente Blade: Icona per input dei form

Props:
- icon: tipo di icona da mostrare (user, envelope, lock)

Funzionalità:
- Mostra un’icona posizionata a sinistra dentro un input
- Usa SVG ottimizzati e coerenti con lo stile Automarket (verde neon)
- Gestisce automaticamente quale icona mostrare in base al valore passato

Utilizzo:
    <x-input-icon icon="user" />
--}}

@props(['icon'])

<span class="absolute left-3 top-2.5 text-green-400">

    {{-- Icona utente --}}
    @if ($icon === 'user')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5.121 17.804A9.004 9.004 0 0112 15c2.21 0 4.21.805 5.879 2.137M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>

        {{-- Icona email --}}
    @elseif ($icon === 'envelope')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M16 12l-4-4-4 4m0 0l4 4 4-4m-4-4v8" />
        </svg>

        {{-- Icona lucchetto --}}
    @elseif ($icon === 'lock')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 15v2m0-6a2 2 0 00-2 2v4a2 2 0 004 0v-4a2 2 0 00-2-2zm0-4a4 4 0 00-4 4v2h8v-2a4 4 0 00-4-4z" />
        </svg>
    @endif

</span>
