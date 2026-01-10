<div class="max-w-6xl mx-auto mt-24 px-4 text-white">

    {{-- FILTRI --}}
    <div
        class="bg-gray-800 border border-gray-700 p-6 rounded-lg shadow-lg mb-10 
                grid grid-cols-1 md:grid-cols-4 gap-4">

        {{-- Ricerca --}}
        <input type="text" wire:model.live="search" placeholder="Cerca per titolo o descrizione"
            class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 
                   focus:ring-2 focus:ring-green-500 focus:outline-none">

        {{-- Categoria --}}
        <select wire:model.live="category_id"
            class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 
                   focus:ring-2 focus:ring-green-500 focus:outline-none">
            <option value="">Tutte le categorie</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        {{-- Prezzo minimo --}}
        <input type="number" wire:model.live="price_min" placeholder="Prezzo minimo"
            class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 
                   focus:ring-2 focus:ring-green-500 focus:outline-none">

        {{-- Prezzo massimo --}}
        <input type="number" wire:model.live="price_max" placeholder="Prezzo massimo"
            class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 
                   focus:ring-2 focus:ring-green-500 focus:outline-none">

        {{-- Marca --}}
        <input type="text" wire:model.live="brand" placeholder="Marca"
            class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 
                   focus:ring-2 focus:ring-green-500 focus:outline-none">

        {{-- Anno --}}
        <input type="number" wire:model.live="year" placeholder="Anno"
            class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 
                   focus:ring-2 focus:ring-green-500 focus:outline-none">

        {{-- Km massimi --}}
        <input type="number" wire:model.live="km_max" placeholder="Km massimi"
            class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 
                   focus:ring-2 focus:ring-green-500 focus:outline-none">

        {{-- Ordina --}}
        <select wire:model.live="order"
            class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 
                   focus:ring-2 focus:ring-green-500 focus:outline-none">
            <option value="">Ordina per</option>
            <option value="price_asc">Prezzo crescente</option>
            <option value="price_desc">Prezzo decrescente</option>
        </select>

        {{-- Reset --}}
        <button wire:click="resetFilters"
            class="w-full bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg 
                   transition">
            Reset filtri
        </button>

    </div>

    {{-- RISULTATI --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        @forelse ($cars as $car)
            <div class="bg-gray-800 border border-gray-700 rounded-lg shadow-lg overflow-hidden">

                {{-- CAROUSEL --}}
                <div x-data="{
                    current: 0,
                    total: {{ $car->images->count() }},
                    images: @json($car->images->map(fn($img) => asset('storage/' . $img->path))),
                    next() { this.current = (this.current + 1) % this.total },
                    prev() { this.current = (this.current - 1 + this.total) % this.total },
                    touchStartX: 0,
                    touchEndX: 0,
                    handleTouchStart(e) { this.touchStartX = e.changedTouches[0].screenX },
                    handleTouchEnd(e) {
                        this.touchEndX = e.changedTouches[0].screenX;
                        if (this.touchEndX < this.touchStartX - 50) this.next();
                        if (this.touchEndX > this.touchStartX + 50) this.prev();
                    }
                }" class="relative w-full h-48 overflow-hidden">

                    {{-- Immagini --}}
                    <template x-for="(img, index) in images" :key="index">
                        <img x-show="current === index" x-transition.opacity :src="img"
                            class="absolute inset-0 w-full h-full object-cover" @touchstart="handleTouchStart($event)"
                            @touchend="handleTouchEnd($event)">
                    </template>

                    {{-- Freccia sinistra --}}
                    <button @click="prev()"
                        class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/40 text-white 
                               px-2 py-1 rounded-full text-sm hover:bg-black/60">
                        ‹
                    </button>

                    {{-- Freccia destra --}}
                    <button @click="next()"
                        class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/40 text-white 
                               px-2 py-1 rounded-full text-sm hover:bg-black/60">
                        ›
                    </button>

                    {{-- Indicatori --}}
                    <div class="absolute bottom-2 left-0 right-0 flex justify-center gap-1">
                        <template x-for="(img, index) in images" :key="index">
                            <div @click="current = index" class="w-2 h-2 rounded-full cursor-pointer"
                                :class="current === index ? 'bg-green-500' : 'bg-gray-400'">
                            </div>
                        </template>
                    </div>

                </div>

                {{-- Info auto --}}
                <div class="p-4">
                    <h2 class="text-xl font-bold">{{ $car->title }}</h2>
                    <p class="text-gray-400">{{ $car->category->name }}</p>

                    <p class="text-green-400 font-bold mt-2">
                        € {{ number_format($car->price, 2, ',', '.') }}
                    </p>

                    <a href="{{ route('cars.show', $car) }}"
                        class="inline-block mt-4 bg-green-600 hover:bg-green-700 
                               text-white px-4 py-2 rounded-lg transition">
                        Dettagli
                    </a>
                </div>

            </div>

        @empty

            <p class="text-gray-400 col-span-3 text-center text-lg">
                Nessun annuncio trovato.
            </p>
        @endforelse

    </div>

    {{-- PAGINAZIONE --}}
    <div class="mt-10">
        {{ $cars->links() }}
    </div>

</div>
