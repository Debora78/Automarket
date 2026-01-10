{{-- 
Componente Blade: Lista messaggi di errore

Props:
- messages: array o singolo messaggio da mostrare

Funzionalità:
- Mostra uno o più messaggi di errore in formato lista
- Supporta modalità chiara/scura
- Permette l’aggiunta di classi extra tramite $attributes->merge()
- Converte automaticamente $messages in array se non lo è
--}}

@props(['messages'])

@if ($messages)
    <ul
        {{ $attributes->merge([
            'class' => '
                    text-sm 
                    text-red-600 
                    dark:text-red-400 
                    space-y-1
                ',
        ]) }}>
        {{-- Iterazione dei messaggi (singolo o multipli) --}}
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
