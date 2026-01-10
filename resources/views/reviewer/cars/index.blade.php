{{-- 
Pagina: Annunci in attesa di revisione (Automarket)

Funzionalità:
- Mostra tutti gli annunci che richiedono approvazione da parte di un revisore
- Ogni annuncio mostra marca, modello e prezzo
- Se l’utente autenticato è un revisore, può:
    • Approvare l’annuncio
    • Rifiutare l’annuncio
- Se non ci sono annunci, viene mostrato un messaggio informativo
- Stile coerente con il tema dark + verde Automarket
--}}

<x-app-layout>
    <div class="max-w-5xl mx-auto py-10">

        {{-- Titolo --}}
        <h1 class="text-2xl font-bold text-green-400 mb-6">
            Annunci in attesa di revisione
        </h1>

        {{-- Nessun annuncio --}}
        @if ($cars->isEmpty())
            <p class="text-gray-300">Nessun annuncio in attesa.</p>

            {{-- Lista annunci --}}
        @else
            <div class="space-y-4">

                @foreach ($cars as $car)
                    <div class="bg-gray-800 p-4 rounded flex justify-between items-center">

                        {{-- Info auto --}}
                        <div>
                            <p class="text-white font-semibold">
                                {{ $car->brand }} {{ $car->model }}
                            </p>
                            <p class="text-gray-400 text-sm">
                                {{ $car->price }} €
                            </p>
                        </div>

                        {{-- Azioni revisore --}}
                        <div class="flex gap-3">
                            @auth
                                @if (auth()->user()?->is_reviewer)
                                    {{-- Approva --}}
                                    <form action="{{ route('reviewer.cars.approve', $car) }}" method="POST">
                                        @csrf
                                        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                                            Approva
                                        </button>
                                    </form>

                                    {{-- Rifiuta --}}
                                    <form action="{{ route('reviewer.cars.reject', $car) }}" method="POST">
                                        @csrf
                                        <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                                            Rifiuta
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>

                    </div>
                @endforeach

            </div>
        @endif

    </div>
</x-app-layout>
