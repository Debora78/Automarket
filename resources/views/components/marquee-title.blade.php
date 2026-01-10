{{-- 
Componente Blade: Testo scorrevole (Marquee)

Props:
- text: testo da far scorrere orizzontalmente

Funzionalità:
- Effetto marquee fluido tramite animazione CSS personalizzata (animate-marquee)
- Doppia copia del testo per garantire continuità nello scorrimento
- Stile Automarket: gradiente verde neon + glow
- Layout responsive con dimensioni dinamiche del font

Utilizzo:
    <x-marquee text="Benvenuto su AutoMarket" />
--}}

@props(['text'])

<div class="relative w-full overflow-x-hidden whitespace-nowrap mb-8 py-2">

    {{-- Contenitore animato --}}
    <div class="flex animate-marquee gap-16">

        {{-- Prima copia del testo --}}
        <span
            class="text-4xl md:text-5xl font-extrabold leading-relaxed
               text-transparent bg-clip-text 
               bg-gradient-to-r from-green-400 via-green-500 to-green-600
               drop-shadow-[0_0_25px_#22c55e]">
            {{ $text }}
        </span>

        {{-- Seconda copia per continuità dell’animazione --}}
        <span
            class="text-4xl md:text-5xl font-extrabold leading-relaxed
               text-transparent bg-clip-text 
               bg-gradient-to-r from-green-400 via-green-500 to-green-600
               drop-shadow-[0_0_25px_#22c55e]">
            {{ $text }}
        </span>

    </div>
</div>
