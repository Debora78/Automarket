{{-- 
Pagina: Inserimento nuovo annuncio (Automarket)

Funzionalità:
- Layout dark professionale con neon verde
- Form strutturato in griglia responsive
- Campi Livewire con anteprima immagini
- Accessori selezionabili
- Pulsante CTA coerente con il tema Automarket
--}}

<div class="bg-gray-900 text-white min-h-screen px-10 py-20 mt-20">

    <div class="max-w-7xl mx-auto bg-gray-800 p-16 rounded-2xl shadow-xl">

        {{-- Titolo --}}
        <h1
            class="text-3xl font-bold mb-12 text-transparent bg-clip-text bg-gradient-to-r
               from-green-400 via-green-500 to-green-600
               drop-shadow-[0_0_20px_#22c55e] text-center">
            Inserisci un nuovo annuncio
        </h1>

        {{-- Messaggio di successo --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-600 text-white rounded-lg shadow">
                {{ session('success') }}
            </div>
        @endif

        {{-- Messaggio di errore generico --}}
        @if (session('error'))
            <div class="mb-6 p-4 bg-red-600 text-white rounded-lg shadow">
                {{ session('error') }}
            </div>
        @endif

        {{-- Errori di validazione --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-600 text-white rounded-lg shadow">
                <ul class="list-disc ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif




        {{-- Form --}}
        <form wire:submit.prevent="store" class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-x-14 gap-y-12">

            {{-- Tipo --}}
            <div class="space-y-3">
                <label class="text-sm font-semibold text-gray-300">Tipo</label>
                <select wire:model="listing_type" class="w-full rounded bg-gray-700 text-white border-gray-600 p-3">
                    <option value="sale_new">Auto nuova</option>
                    <option value="sale_used">Auto usata</option>
                    <option value="rental">Noleggio</option>
                </select>
            </div>

            {{-- Colore --}}
            <div class="space-y-3">
                <label class="text-sm font-semibold text-gray-300">Colore</label>
                <select wire:model="color" class="w-full rounded bg-gray-700 text-white border-gray-600 p-3">
                    <option value="">Seleziona</option>
                    <option value="Bianco">Bianco</option>
                    <option value="Nero">Nero</option>
                    <option value="Grigio">Grigio</option>
                    <option value="Blu">Blu</option>
                    <option value="Rosso">Rosso</option>
                    <option value="Argento">Argento</option>
                </select>
            </div>

            {{-- Categoria --}}
            <div class="space-y-3">
                <label class="text-sm font-semibold text-gray-300">Categoria</label>
                <select wire:model="category_id" class="w-full rounded bg-gray-700 text-white border-gray-600 p-3">
                    <option value="">Seleziona</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Marca --}}
            <div class="space-y-3">
                <label class="text-sm font-semibold text-gray-300">Marca</label>
                <input type="text" wire:model="brand"
                    class="w-full rounded bg-gray-700 text-white border-gray-600 p-3">
            </div>

            {{-- Anno --}}
            <div class="space-y-3">
                <label class="text-sm font-semibold text-gray-300">Anno</label>
                <input type="number" wire:model="year"
                    class="w-full rounded bg-gray-700 text-white border-gray-600 p-3">
            </div>

            {{-- Prezzo --}}
            <div class="space-y-3">
                <label class="text-sm font-semibold text-gray-300">Prezzo (€)</label>
                <input type="number" wire:model="price"
                    class="w-full rounded bg-gray-700 text-white border-gray-600 p-3">
            </div>

            {{-- Km --}}
            <div class="space-y-3">
                <label class="text-sm font-semibold text-gray-300">Km</label>
                <input type="number" wire:model="km" class="w-full rounded bg-gray-700 text-white border-gray-600 p-3">
            </div>

            {{-- Titolo --}}
            <div class="col-span-1 md:col-span-2 xl:col-span-4 space-y-3">
                <label class="text-sm font-semibold text-gray-300">Titolo</label>
                <input type="text" wire:model="title"
                    class="w-full rounded bg-gray-700 text-white border-gray-600 p-3">
            </div>

            {{-- Descrizione --}}
            <div class="col-span-1 md:col-span-2 xl:col-span-4 space-y-3">
                <label class="text-sm font-semibold text-gray-300">Descrizione</label>
                <textarea wire:model="description" class="w-full rounded bg-gray-700 text-white border-gray-600 p-3 h-32"></textarea>
            </div>

            {{-- Immagini --}}
            <div class="col-span-1 md:col-span-2 xl:col-span-4 space-y-3">
                <label class="text-sm font-semibold text-gray-300">Immagini</label>
                <input type="file" wire:model="images" multiple
                    class="w-full rounded bg-gray-700 text-white border-gray-600 p-3">

                @if ($images)
                    <div class="grid grid-cols-3 gap-4 mt-4">
                        @foreach ($images as $image)
                            <img src="{{ $image->temporaryUrl() }}" class="rounded shadow-lg object-cover">
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Accessori --}}
            <div class="col-span-1 md:col-span-2 xl:col-span-4 space-y-3">
                <label class="text-sm font-semibold text-gray-300">Accessori</label>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach (['Climatizzatore', 'Navigatore', 'Bluetooth', 'Sensori parcheggio', 'Cruise control', 'Cerchi in lega', 'Sedili riscaldati', 'Telecamera posteriore'] as $acc)
                        <label class="flex items-center space-x-2 text-gray-300">
                            <input type="checkbox" wire:model="selected_accessories" value="{{ $acc }}"
                                class="bg-gray-700 border-gray-600 text-green-500 rounded">
                            <span>{{ $acc }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Bottone --}}
            <div class="col-span-1 md:col-span-2 xl:col-span-4 text-center mt-12">
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white font-semibold
                           px-10 py-4 rounded-lg shadow-lg transition">
                    Salva annuncio
                </button>
            </div>

        </form>
    </div>
</div>
