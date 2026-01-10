{{-- 
Componente Blade: Titolo con effetto macchina da scrivere (typewriter)

Props:
- text: testo da animare
- speed: velocità di digitazione (ms per carattere, default 80)

Funzionalità:
- Usa Alpine.js con una funzione typewriter(text, speed)
  che deve essere definita nel tuo custom.js
- Anima il testo lettera per lettera
- Stile Automarket: gradiente verde neon + glow
- Responsive e centrato

Utilizzo:
    <x-typewriter-title text="Benvenuto su AutoMarket" speed="60" />
--}}

@props(['text', 'speed' => 80])

<h1 x-data="typewriter('{{ $text }}', {{ $speed }})" x-init="start()"
    class="text-4xl md:text-5xl font-extrabold text-center pt-4 pb-24
       text-transparent bg-clip-text 
       bg-gradient-to-r from-green-400 via-green-500 to-green-600
       drop-shadow-[0_0_25px_#22c55e]">
    <span x-text="displayed"></span>
</h1>
