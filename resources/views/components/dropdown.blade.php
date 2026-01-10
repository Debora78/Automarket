{{-- 
Componente Blade: Dropdown personalizzabile

Props:
- align: allineamento del menu (left, right, top)
- width: larghezza del dropdown (default: 48)
- contentClasses: classi applicate al contenitore interno

Funzionalità:
- Usa Alpine.js per gestire apertura/chiusura
- Supporta RTL e LTR
- Supporta transizioni animate
- Trigger e contenuto vengono passati tramite slot:
    • {{ $trigger }}  → elemento che apre il menu
    • {{ $content }}  → contenuto del dropdown

Utilizzo:
    <x-dropdown>
        <x-slot name="trigger"> ... </x-slot>
        <x-slot name="content"> ... </x-slot>
    </x-dropdown>
--}}

@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white dark:bg-gray-700'])

@php
    // Classi per l’allineamento del dropdown
    $alignmentClasses = match ($align) {
        'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
        'top' => 'origin-top',
        default => 'ltr:origin-top-right rtl:origin-top-left end-0',
    };

    // Larghezza del menu
    $width = match ($width) {
        '48' => 'w-48',
        default => $width,
    };
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">

    {{-- Trigger del dropdown (clic per aprire/chiudere) --}}
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    {{-- Contenitore del menu --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 mt-2 {{ $width }} rounded-md shadow-lg {{ $alignmentClasses }}"
        style="display: none;" @click="open = false">
        {{-- Contenuto del dropdown --}}
        <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
