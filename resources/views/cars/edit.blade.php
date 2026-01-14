{{-- 
Pagina: Modifica annuncio
Funzionalità:
- Form precompilato
- Validazione errori
- Stile dark + neon Automarket
--}}

<x-layout>

    <div class="max-w-3xl mx-auto mt-24 bg-gray-900 text-white p-8 rounded-lg shadow-lg border border-green-400">

        {{-- Titolo --}}
        <h1 class="text-3xl font-bold text-green-400 mb-6">
            Modifica annuncio
        </h1>

        {{-- Messaggi di errore --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-600 text-white rounded-lg shadow">
                <ul class="list-disc ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form aggiornamento --}}
        <form action="{{ route('cars.update', $car) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Titolo --}}
            <div>
                <label class="block mb-1 text-gray-300">Titolo</label>
                <input type="text" name="title" value="{{ old('title', $car->title) }}"
                    class="w-full bg-gray-800 border border-gray-700 rounded px-3 py-2 text-white">
            </div>

            {{-- Descrizione --}}
            <div>
                <label class="block mb-1 text-gray-300">Descrizione</label>
                <textarea name="description" rows="5"
                    class="w-full bg-gray-800 border border-gray-700 rounded px-3 py-2 text-white">{{ old('description', $car->description) }}</textarea>
            </div>

            {{-- Prezzo --}}
            <div>
                <label class="block mb-1 text-gray-300">Prezzo (€)</label>
                <input type="number" name="price" value="{{ old('price', $car->price) }}"
                    class="w-full bg-gray-800 border border-gray-700 rounded px-3 py-2 text-white">
            </div>

            {{-- Tipo annuncio --}}
            <div>
                <label class="block mb-1 text-gray-300">Tipo annuncio</label>
                <select name="type" class="w-full bg-gray-800 border border-gray-700 rounded px-3 py-2 text-white">
                    <option value="sale_new" {{ $car->type === 'sale_new' ? 'selected' : '' }}>Auto nuova</option>
                    <option value="sale_used" {{ $car->type === 'sale_used' ? 'selected' : '' }}>Auto usata</option>
                    <option value="rental" {{ $car->type === 'rental' ? 'selected' : '' }}>Noleggio</option>
                </select>
            </div>

            {{-- Pulsante salva --}}
            <button class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded text-white font-semibold">
                Salva modifiche
            </button>
        </form>

        {{-- Pulsante elimina annuncio --}}
        <form action="{{ route('cars.destroy', $car) }}" method="POST" class="mt-6"
            onsubmit="return confirm('Sei sicura di voler eliminare questo annuncio?')">
            @csrf
            @method('DELETE')

            <button class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-white font-semibold">
                Elimina annuncio
            </button>
        </form>

    </div>

</x-layout>
