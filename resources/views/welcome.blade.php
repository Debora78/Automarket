{{-- 
Pagina: Hero animato della homepage (Automarket)

Funzionalità:
- Mostra un titolo principale con effetto macchina da scrivere (Alpine.js)
- Al termine del titolo, avvia automaticamente il sottotitolo con lo stesso effetto
- Layout fullscreen centrato, con tema dark e gradiente verde Automarket
- Perfetto come sezione di benvenuto o splash screen
--}}

<x-layout>
    <div x-data="{ subtitleStart: false }" class="flex flex-col items-center justify-center min-h-screen bg-gray-900 text-center">

        {{-- TITOLO PRINCIPALE --}}
        <h1 x-data="typewriter('Benvenuti su AutoMarket!', 80, () => subtitleStart = true)" x-init="start()"
            class="text-6xl md:text-7xl font-extrabold text-transparent bg-clip-text
               bg-gradient-to-r from-green-400 via-green-500 to-green-600 mb-6
               drop-shadow-[0_0_25px_#22c55e]">
            <span x-text="displayed"></span>
        </h1>

        {{-- SOTTOTITOLO --}}
        <h2 x-show="subtitleStart" x-transition.opacity.duration.500ms x-data="typewriter('Trova la tua auto e realizza i tuoi sogni', 60)" x-init="$watch('subtitleStart', value => value && start())"
            class="text-2xl md:text-3xl font-semibold text-transparent bg-clip-text
               bg-gradient-to-r from-green-400 via-green-500 to-green-600
               drop-shadow-[0_0_20px_#22c55e]">
            <span x-text="displayed"></span>
        </h2>

    </div>
</x-layout>
