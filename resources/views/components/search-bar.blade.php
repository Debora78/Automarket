{{-- 
Componente Blade/Livewire: Barra di ricerca Automarket

Funzionalità:
- Campo di ricerca con debounce Livewire (300ms)
- Stile dark con bordo e focus verde neon
- Icona lente posizionata a sinistra tramite absolute positioning
- Layout centrato e responsive

Utilizzo:
    <x-search-bar wire:model="search" />
--}}

<div class="relative max-w-xl mx-auto mb-8">

    {{-- Input ricerca --}}
    <input type="text" wire:model.debounce.300ms="search" placeholder="Cerca marca, modello, categoria..."
        class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg 
           py-3 px-4 pl-12 
           focus:ring-2 focus:ring-green-500 focus:outline-none">

    {{-- Icona lente --}}
    <span class="absolute left-4 top-3.5 text-gray-400">
        🔍
    </span>

</div>
