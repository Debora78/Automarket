{{-- 
Pagina di conferma pagamento.
Mostra un messaggio di successo dopo il checkout e invita l’utente
a tornare alla homepage. Layout semplice, pulito e coerente con il tema.
--}}

<x-app-layout>
    <div class="max-w-3xl mx-auto py-20 text-center">

        {{-- Titolo di conferma --}}
        <h1 class="text-3xl font-bold text-green-400 mb-4">
            Pagamento completato!
        </h1>

        {{-- Messaggio informativo --}}
        <p class="text-gray-300 mb-6">
            Grazie per il tuo acquisto. Ti abbiamo inviato un'email con la conferma dell’ordine.
        </p>

        {{-- Pulsante ritorno alla home --}}
        <a href="{{ route('home') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg">
            Torna alla Home
        </a>

    </div>
</x-app-layout>
