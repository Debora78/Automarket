{{-- 
Componente Blade: Input generico

Props:
- disabled: boolean per disabilitare l’input

Funzionalità:
- Applica automaticamente lo stile base per input in tema chiaro/scuro
- Supporta merge degli attributi per classi aggiuntive
- Usa la direttiva @disabled per gestire lo stato disabilitato
- Include focus ring e border color coerenti con il resto del design

Utilizzo:
    <x-input type="text" name="email" />
    <x-input type="text" name="email" disabled />
--}}

@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge([
        'class' => '
            border-gray-300 
            dark:border-gray-700 
            dark:bg-gray-900 
            dark:text-gray-300 
            focus:border-indigo-500 
            dark:focus:border-indigo-600 
            focus:ring-indigo-500 
            dark:focus:ring-indigo-600 
            rounded-md 
            shadow-sm
        ',
    ]) }}>
