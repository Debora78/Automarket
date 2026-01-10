{{-- 
Componente Blade: Etichetta per input dei form

Props:
- value: testo dell’etichetta (opzionale)
  Se non fornito, viene usato lo slot interno.

Funzionalità:
- Applica automaticamente lo stile tipico delle label nei form
- Supporta modalità chiara/scura
- Permette override o aggiunta di classi tramite $attributes->merge()
- Utilizzo tipico:
    <x-input-label for="email" value="Email" />
    oppure:
    <x-input-label for="email">Email</x-input-label>
--}}

@props(['value'])

<label
    {{ $attributes->merge([
        'class' => '
            block 
            font-medium 
            text-sm 
            text-gray-700 
            dark:text-gray-300
        ',
    ]) }}>
    {{ $value ?? $slot }}
</label>
