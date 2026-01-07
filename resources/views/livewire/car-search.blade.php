<div class="container mx-auto mt-10">

    <!-- FILTRI -->
    <div class="bg-white p-6 shadow rounded mb-8 grid grid-cols-1 md:grid-cols-4 gap-4">

        <input type="text" wire:model.live="search" placeholder="Cerca per titolo o descrizione"
            class="border rounded px-3 py-2 w-full">

        <select wire:model.live="category_id" class="border rounded px-3 py-2 w-full">
            <option value="">Tutte le categorie</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <input type="number" wire:model.live="price_min" placeholder="Prezzo minimo"
            class="border rounded px-3 py-2 w-full">

        <input type="number" wire:model.live="price_max" placeholder="Prezzo massimo"
            class="border rounded px-3 py-2 w-full">

        <input type="text" wire:model.live="brand" placeholder="Marca" class="border rounded px-3 py-2 w-full">

        <input type="number" wire:model.live="year" placeholder="Anno" class="border rounded px-3 py-2 w-full">

        <input type="number" wire:model.live="km_max" placeholder="Km massimi" class="border rounded px-3 py-2 w-full">

        <select wire:model.live="order" class="border rounded px-3 py-2 w-full">
            <option value="">Ordina per</option>
            <option value="price_asc">Prezzo crescente</option>
            <option value="price_desc">Prezzo decrescente</option>
        </select>

        <button wire:click="resetFilters" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded w-full">
            Reset filtri
        </button>

    </div>

    <!-- RISULTATI -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        @forelse ($cars as $car)
            <div class="bg-white shadow rounded overflow-hidden">

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
                }" class="relative w-full h-48 overflow-hidden rounded">

                    <!-- IMMAGINI -->
                    <template x-for="(img, index) in images" :key="index">
                        <img x-show="current === index" x-transition.opacity :src="img"
                            class="absolute inset-0 w-full h-full object-cover" @touchstart="handleTouchStart($event)"
                            @touchend="handleTouchEnd($event)">
                    </template>

                    <!-- FRECCIA SINISTRA -->
                    <button @click="prev()"
                        class="absolute left-1 top-1/2 -translate-y-1/2 bg-white/70 px-2 py-1 rounded-full shadow text-sm">
                        ‹
                    </button>

                    <!-- FRECCIA DESTRA -->
                    <button @click="next()"
                        class="absolute right-1 top-1/2 -translate-y-1/2 bg-white/70 px-2 py-1 rounded-full shadow text-sm">
                        ›
                    </button>

                    <!-- PALLINI -->
                    <div class="absolute bottom-2 left-0 right-0 flex justify-center gap-1">
                        <template x-for="(img, index) in images" :key="index">
                            <div @click="current = index" class="w-2 h-2 rounded-full cursor-pointer"
                                :class="current === index ? 'bg-blue' : 'bg-gray-300'"></div>
                        </template>
                    </div>

                </div>

                <div class="p-4">
                    <h2 class="text-xl font-bold">{{ $car->title }}</h2>
                    <p class="text-gray-600">{{ $car->category->name }}</p>
                    <p class="text-blue font-bold mt-2">
                        € {{ number_format($car->price, 2, ',', '.') }}
                    </p>

                    <a href="{{ route('cars.show', $car) }}"
                        class="inline-block mt-4 bg-blue text-white px-4 py-2 rounded">
                        Dettagli
                    </a>
                </div>

            </div>
        @empty
            <p class="text-gray-600 col-span-3">Nessun annuncio trovato.</p>
        @endforelse

    </div>

    <!-- PAGINAZIONE -->
    <div class="mt-6">
        {{ $cars->links() }}
    </div>



</div>
