{{-- 
Pagina: Gestione profilo utente (Automarket)

Funzionalità:
- Mostra tre sezioni principali del profilo:
    1. Aggiornamento informazioni personali (nome, email)
    2. Aggiornamento password
    3. Eliminazione account
- Ogni sezione è inclusa tramite partial Blade per mantenere il codice modulare
- Layout coerente con Jetstream e tema dark/light Automarket
- Utilizza <x-app-layout> per mantenere header e struttura globale dell’app
--}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Sezione: Informazioni profilo --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Sezione: Aggiornamento password --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Sezione: Eliminazione account --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
