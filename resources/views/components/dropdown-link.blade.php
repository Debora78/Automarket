{{-- 
Componente Blade: voce di menu / dropdown link

Utilizzo:
    <x-dropdown-link href="/profilo">Profilo</x-dropdown-link>

Caratteristiche:
- wrapper <a> completamente personalizzabile tramite $attributes
- stile coerente con i menu di Breeze/Jetstream
- supporta modalità chiara/scura
- hover e focus con transizioni morbide
- contenuto dinamico tramite {{ $slot }}
--}}

<a
    {{ $attributes->merge([
        'class' => '
            block w-full 
            px-4 py-2 
            text-start text-sm leading-5 
            text-gray-700 dark:text-gray-300 
            hover:bg-gray-100 dark:hover:bg-gray-800 
            focus:outline-none 
            focus:bg-gray-100 dark:focus:bg-gray-800 
            transition duration-150 ease-in-out
        ',
    ]) }}>
    {{ $slot }}
</a>
