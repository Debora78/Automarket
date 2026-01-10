{{-- 
Pagina "Password dimenticata".
Permette all’utente di richiedere un link per reimpostare la password.
Laravel invierà automaticamente l’email se l’indirizzo è valido.
--}}

<x-guest-layout>

    {{-- Messaggio introduttivo --}}
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    {{-- Stato della sessione (es. "Email inviata") --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- Form invio email reset password --}}
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        {{-- Campo email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />

            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus />

            {{-- Errori di validazione --}}
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Pulsante invio --}}
        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>
