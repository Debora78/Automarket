{{-- 
Componente Blade: <x-auth-session-status />

Scopo:
- Mostrare un messaggio di stato (es. "Password reset link inviato")
- Viene usato nelle pagine di login, registrazione, reset password, ecc.
- Mostra il messaggio solo se $status è valorizzato
--}}

@props(['status'])

@if ($status)
    <div {{ $attributes->merge([
        'class' => 'font-medium text-sm text-green-600 dark:text-green-400',
    ]) }}>
        {{ $status }}
    </div>
@endif
