{{-- 
Componente Blade: pulsante rosso (submit)
Utilizzo:
    <x-danger-button>Elimina</x-danger-button>

Caratteristiche:
- stile rosso per azioni distruttive (delete, logout, reset)
- merge degli attributi per permettere override da fuori
- supporta contenuto dinamico tramite {{ $slot }}
--}}

<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => '
            inline-flex items-center 
            px-4 py-2 
            bg-red-600 
            border border-transparent 
            rounded-md 
            font-semibold 
            text-xs text-white uppercase tracking-widest 
            hover:bg-red-500 
            active:bg-red-700 
            focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 
            dark:focus:ring-offset-gray-800 
            transition ease-in-out duration-150
        ',
    ]) }}>
    {{ $slot }}
</button>
