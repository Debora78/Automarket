@props(['categories', 'filter_type'])

<div class="bg-gray-800 p-6 rounded-lg shadow-lg custom-navbar-glow text-white">

    {{-- Titolo dinamico --}}
    <h1
        class="text-3xl font-bold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-green-400 via-green-500 to-green-600 drop-shadow-[0_0_20px_#22c55e]">
        @if ($filter_type === 'sale_new')
            Visita la nostra flotta di auto nuove
        @elseif ($filter_type === 'sale_used')
            Scopri le nostre occasioni usate
        @elseif ($filter_type === 'rental')
            Noleggia l'auto perfetta per te
        @else
            Filtra le auto disponibili
        @endif
    </h1>

    <h2 class="text-xl font-semibold mb-4 text-gray-300">Filtri</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

        <!-- Tipo annuncio -->
        <div>
            <label class="text-sm font-semibold text-gray-300">Tipo</label>
            <select wire:model="filter_type" class="w-full mt-1 rounded bg-gray-700 text-white border-gray-600 p-2">
                <option value="">Tutti</option>
                <option value="sale_new">Nuove</option>
                <option value="sale_used">Usate</option>
                <option value="rental">Noleggio</option>
            </select>
        </div>

        <!-- Colore -->
        <div>
            <label class="text-sm font-semibold text-gray-300">Colore</label>
            <select wire:model="filter_color" class="w-full mt-1 rounded bg-gray-700 text-white border-gray-600 p-2">
                <option value="">Tutti</option>
                <option value="Bianco">Bianco</option>
                <option value="Nero">Nero</option>
                <option value="Grigio">Grigio</option>
                <option value="Blu">Blu</option>
                <option value="Rosso">Rosso</option>
                <option value="Argento">Argento</option>
            </select>
        </div>

        <!-- Categoria -->
        <div>
            <label class="text-sm font-semibold text-gray-300">Categoria</label>
            <select wire:model="filter_category" class="w-full mt-1 rounded bg-gray-700 text-white border-gray-600 p-2">
                <option value="">Tutte</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Marca -->
        <div>
            <label class="text-sm font-semibold text-gray-300">Marca</label>
            <input type="text" wire:model="filter_brand"
                class="w-full mt-1 rounded bg-gray-700 text-white border-gray-600 p-2">
        </div>

        <!-- Anno -->
        <div>
            <label class="text-sm font-semibold text-gray-300">Anno</label>
            <input type="number" wire:model="filter_year"
                class="w-full mt-1 rounded bg-gray-700 text-white border-gray-600 p-2">
        </div>

        <!-- Prezzo min -->
        <div>
            <label class="text-sm font-semibold text-gray-300">Prezzo min</label>
            <input type="number" wire:model="filter_price_min"
                class="w-full mt-1 rounded bg-gray-700 text-white border-gray-600 p-2">
        </div>

        <!-- Prezzo max -->
        <div>
            <label class="text-sm font-semibold text-gray-300">Prezzo max</label>
            <input type="number" wire:model="filter_price_max"
                class="w-full mt-1 rounded bg-gray-700 text-white border-gray-600 p-2">
        </div>

        <!-- Accessori -->
        <div class="col-span-1 md:col-span-2 lg:col-span-4">
            <label class="text-sm font-semibold text-gray-300">Accessori</label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 mt-2">
                @foreach (['Climatizzatore', 'Navigatore', 'Bluetooth', 'Sensori parcheggio', 'Cruise control', 'Cerchi in lega', 'Sedili riscaldati', 'Telecamera posteriore'] as $acc)
                    <label class="flex items-center space-x-2 text-gray-300">
                        <input type="checkbox" wire:model="filter_accessories" value="{{ $acc }}"
                            class="bg-gray-700 border-gray-600 text-green-500">
                        <span>{{ $acc }}</span>
                    </label>
                @endforeach
            </div>
        </div>

    </div>
</div>
<!-- Bottone Cerca -->
<div class="mt-6 text-center">
    <button wire:click="applyFilters"
        class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-2 rounded-lg shadow">
        Cerca
    </button>
</div>
