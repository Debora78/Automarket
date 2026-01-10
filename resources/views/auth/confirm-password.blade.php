{{-- 
Pagina di conferma password.
Questa vista viene mostrata quando l’utente sta per eseguire un’azione sensibile
(come modificare email, password o impostazioni critiche) e Laravel richiede
una conferma della password per motivi di sicurezza.
--}}

<x-guest-layout>

    {{-- Messaggio introduttivo --}}
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    {{-- Form di conferma password --}}
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        {{-- Campo password --}}
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            {{-- Errori di validazione --}}
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Pulsante di conferma --}}
        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>
