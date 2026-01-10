{{-- 
Componente Blade: Titolo principale in stile Automarket

Funzionalità:
- Titolo grande, centrato e con font extrabold
- Gradiente verde neon + effetto glow
- Responsive: dimensioni diverse su mobile/desktop
- Usa lo slot per inserire qualsiasi testo dinamico

Utilizzo:
    <x-page-title>Le nostre auto</x-page-title>
--}}

<h1
    class="text-4xl md:text-5xl font-extrabold text-center mb-8 leading-relaxed
       text-transparent bg-clip-text 
       bg-gradient-to-r from-green-400 via-green-500 to-green-600
       drop-shadow-[0_0_25px_#22c55e]">
    {{ $slot }}
</h1>
