{{-- 
Pagina di registrazione personalizzata per Automarket.
Layout moderno, responsive e con accenti verde neon coerenti con il brand.
La pagina è divisa in due sezioni:
- sinistra: testo introduttivo
- destra: form di registrazione
--}}

<x-guest-layout title="Registrati per viaggiare in Automarket! Ti aspettiamo!">

    {{-- Contenitore principale --}}
    <div
        class="w-full max-w-4xl bg-gray-800 p-10 rounded-xl shadow-xl 
           flex flex-col md:flex-row gap-10 items-center justify-between">

        {{-- Sezione sinistra: titolo + descrizione --}}
        <div class="flex-1 text-center md:text-left">
            <h1
                class="text-3xl font-bold mb-4 text-transparent bg-clip-text bg-gradient-to-r
                from-green-400 via-green-500 to-green-600 drop-shadow-[0_0_20px_#22c55e]">
                Crea il tuo account
            </h1>

            <p class="text-gray-300 text-sm leading-relaxed">
                Unisciti a noi e scopri le migliori auto nuove, usate e a noleggio.
                Registrati in pochi secondi e inizia il tuo viaggio con Automarket.
            </p>
        </div>

        {{-- Sezione destra: form di registrazione --}}
        <div class="flex-1 w-full">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                {{-- Nome --}}
                <div class="space-y-2">
                    <x-input-label for="name" :value="__('Nome')" class="text-sm font-semibold text-gray-300" />

                    <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus
                        class="w-full rounded bg-gray-700 text-white border-gray-600 p-3" />

                    <x-input-error :messages="$errors->get('name')" class="text-red-400 text-sm mt-1" />
                </div>

                {{-- Cognome --}}
                <div class="space-y-2">
                    <x-input-label for="surname" :value="__('Cognome')" class="text-sm font-semibold text-gray-300" />

                    <x-text-input id="surname" type="text" name="surname" :value="old('surname')" required
                        class="w-full rounded bg-gray-700 text-white border-gray-600 p-3" />

                    <x-input-error :messages="$errors->get('surname')" class="text-red-400 text-sm mt-1" />
                </div>

                {{-- Email --}}
                <div class="space-y-2">
                    <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-gray-300" />

                    <x-text-input id="email" type="email" name="email" :value="old('email')" required
                        class="w-full rounded bg-gray-700 text-white border-gray-600 p-3" />

                    <x-input-error :messages="$errors->get('email')" class="text-red-400 text-sm mt-1" />
                </div>

                {{-- Password --}}
                <div class="space-y-2">
                    <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-gray-300" />

                    <x-text-input id="password" type="password" name="password" required autocomplete="new-password"
                        class="w-full rounded bg-gray-700 text-white border-gray-600 p-3" />

                    <x-input-error :messages="$errors->get('password')" class="text-red-400 text-sm mt-1" />
                </div>

                {{-- Conferma Password --}}
                <div class="space-y-2">
                    <x-input-label for="password_confirmation" :value="__('Conferma Password')"
                        class="text-sm font-semibold text-gray-300" />

                    <x-text-input id="password_confirmation" type="password" name="password_confirmation" required
                        class="w-full rounded bg-gray-700 text-white border-gray-600 p-3" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="text-red-400 text-sm mt-1" />
                </div>

                {{-- Link login --}}
                <div class="flex items-center justify-end">
                    <a href="{{ route('login') }}" class="text-sm text-green-400 hover:underline">
                        Hai già un account?
                    </a>
                </div>

                {{-- Pulsante submit --}}
                <x-primary-button
                    class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-2 rounded-lg shadow text-center">
                    {{ __('Registrati') }}
                </x-primary-button>

            </form>
        </div>

    </div>

</x-guest-layout>
