{{-- 
Componente Blade: Link della navbar (stato attivo/inattivo)

Props:
- active: boolean che indica se il link rappresenta la pagina corrente

Funzionalità:
- Applica automaticamente lo stile "attivo" con bordo inferiore colorato
- In stato inattivo mostra un bordo trasparente e cambia colore al passaggio del mouse
- Supporta modalità chiara/scura
- Permette override di attributi tramite $attributes->merge()
- Utilizzo tipico:
    <x-nav-link href="/dashboard" :active="request()->routeIs('dashboard')">
        Dashboard
    </x-nav-link>
--}}

@props(['active'])

@php
    // Classi dinamiche in base allo stato attivo
    $classes =
        $active ?? false
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 dark:border-indigo-600 
               text-sm font-medium leading-5 text-gray-900 dark:text-gray-100 
               focus:outline-none focus:border-indigo-700 
               transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent 
               text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 
               hover:text-gray-700 dark:hover:text-gray-300 
               hover:border-gray-300 dark:hover:border-gray-700 
               focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 
               focus:border-gray-300 dark:focus:border-gray-700 
               transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
