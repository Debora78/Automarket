{{-- 
Pagina: I miei annunci
Funzionalità:
- Lista annunci dell’utente autenticato
- Stato revisione (in revisione / approvato / rifiutato)
- Pulsanti: modifica, elimina, vai all’annuncio
- Stile dark + neon Automarket
--}}

<x-layout>

    <div class="max-w-6xl mx-auto mt-24 text-white">

        {{-- Titolo --}}
        <h1 class="text-3xl font-bold text-green-400 mb-8">
            I miei annunci
        </h1>

        {{-- Nessun annuncio --}}
        @if ($cars->isEmpty())
            <div class="bg-gray-800 border border-green-400 p-6 rounded-lg text-center">
                <p class="text-gray-300">Non hai ancora pubblicato nessun annuncio.</p>
                <a href="{{ route('cars.create') }}"
                    class="mt-4 inline-block bg-green-500 hover:bg-green-600 px-4 py-2 rounded text-white">
                    Inserisci il tuo primo annuncio
                </a>
            </div>
        @else
            {{-- Griglia annunci --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach ($cars as $car)
                    <div class="bg-gray-900 border border-gray-700 rounded-lg shadow-lg overflow-hidden">

                        {{-- Immagine --}}
                        <img src="{{ asset('storage/' . $car->images->first()->thumbnail) }}"
                            class="w-full h-48 object-cover">

                        <div class="p-4">

                            {{-- Titolo --}}
                            <h2 class="text-xl font-semibold text-green-300">
                                {{ $car->title }}
                            </h2>

                            {{-- Prezzo --}}
                            <p class="text-gray-300 mt-1">
                                € {{ number_format($car->price, 0, ',', '.') }}
                            </p>

                            {{-- Stato revisione --}}
                            <div class="mt-3">
                                @if ($car->is_accepted === null)
                                    <span class="bg-yellow-500 text-black px-2 py-1 rounded text-xs">
                                        In revisione
                                    </span>
                                @elseif ($car->is_accepted)
                                    <span class="bg-green-600 px-2 py-1 rounded text-xs">
                                        Approvato
                                    </span>
                                @else
                                    <span class="bg-red-600 px-2 py-1 rounded text-xs">
                                        Rifiutato
                                    </span>
                                @endif
                            </div>

                            {{-- Pulsanti --}}
                            <div class="mt-4 flex justify-between">

                                {{-- Vai all’annuncio --}}
                                <a href="{{ route('cars.show', $car) }}"
                                    class="text-green-400 hover:text-green-300 text-sm">
                                    Vedi annuncio
                                </a>

                                {{-- Modifica (se vuoi abilitarla in futuro) --}}
                                {{-- <a href="#" class="text-yellow-400 hover:text-yellow-300 text-sm">Modifica</a> --}}

                                {{-- Elimina --}}
                                <form action="{{ route('cars.destroy', $car) }}" method="POST"
                                    onsubmit="return confirm('Sei sicura di voler eliminare questo annuncio?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 hover:text-red-400 text-sm">
                                        Elimina
                                    </button>
                                </form>

                            </div>

                        </div>
                    </div>
                @endforeach

            </div>

        @endif

    </div>

</x-layout>
