{{-- 
Pagina di dettaglio auto.
Mostra tutte le informazioni principali dell’annuncio:
- titolo, categoria, tipo annuncio
- colore, accessori, prezzo
- pulsante per aggiungere al carrello
- carousel immagini con swipe + fullscreen
- descrizione e autore dell’annuncio
--}}

<x-layout>

    <div class="container mx-auto mt-10">

        {{-- Titolo annuncio --}}
        <h1 class="text-3xl font-bold mb-4">{{ $car->title }}</h1>

        {{-- Categoria --}}
        <p class="text-gray-600 mb-2">
            Categoria:
            <span class="font-semibold">{{ $car->category->name }}</span>
        </p>

        {{-- Tipo annuncio --}}
        <p class="text-gray-600 mb-2">
            Tipo annuncio:
            <span class="font-semibold">
                @if ($car->listing_type === 'sale_new')
                    Auto nuova
                @elseif ($car->listing_type === 'sale_used')
                    Auto usata
                @else
                    Noleggio
                @endif
            </span>
        </p>

        {{-- Colore --}}
        <p class="text-gray-600 mb-2">
            Colore:
            <span class="font-semibold">{{ $car->color ?? 'N/D' }}</span>
        </p>

        {{-- Accessori --}}
        @if ($car->accessories)
            <p class="text-gray-600 mb-2">
                Accessori:
                <span class="font-semibold">
                    {{ implode(', ', $car->accessories) }}
                </span>
            </p>
        @endif

        {{-- Prezzo --}}
        <p class="text-blue text-2xl font-bold mb-6">
            € {{ number_format($car->price, 2, ',', '.') }}
        </p>

        {{-- Pulsante aggiungi al carrello --}}
        <form action="{{ route('cart.add', $car) }}" method="POST" class="mb-10">
            @csrf
            <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg shadow text-lg">
                Aggiungi al carrello
            </button>
        </form>

        {{-- ---------------------------------------------------------------- --}}
        {{-- CAROUSEL IMMAGINI (Alpine.js + swipe + fullscreen) --}}
        {{-- ---------------------------------------------------------------- --}}
        <div x-data="{
            touchStartX: 0,
            touchEndX: 0,
            handleTouchStart(e) { this.touchStartX = e.changedTouches[0].screenX },
            handleTouchEnd(e) {
                this.touchEndX = e.changedTouches[0].screenX;
                if (this.touchEndX < this.touchStartX - 50) this.next();
                if (this.touchEndX > this.touchStartX + 50) this.prev();
            },
            current: 0,
            total: {{ $car->images->count() }},
            images: @json($car->images->map(fn($img) => asset('storage/' . $img->path))),
            fullscreen: false,
            fullscreenIndex: 0,
            next() { this.current = (this.current + 1) % this.total },
            prev() { this.current = (this.current - 1 + this.total) % this.total }
        }" class="relative w-full max-w-5xl mx-auto mb-10 select-none">

            {{-- Immagine principale --}}
            <div class="overflow-hidden rounded shadow">
                @foreach ($car->images as $index => $image)
                    <img x-show="current === {{ $index }}" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-x-10"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-x-0"
                        x-transition:leave-end="opacity-0 -translate-x-10" src="{{ asset('storage/' . $image->path) }}"
                        class="w-full h-[300px] sm:h-[400px] md:h-[500px] lg:h-[600px] object-cover cursor-pointer"
                        @click="fullscreen = true; fullscreenIndex = current">
                @endforeach
            </div>

            {{-- Freccia sinistra --}}
            <button @click="prev()"
                class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/70 px-3 py-2 rounded-full shadow text-xl">
                ‹
            </button>

            {{-- Freccia destra --}}
            <button @click="next()"
                class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/70 px-3 py-2 rounded-full shadow text-xl">
                ›
            </button>

            {{-- Indicatori (pallini) --}}
            <div class="flex justify-center gap-2 mt-4">
                @foreach ($car->images as $index => $image)
                    <button @click="current = {{ $index }}" class="w-3 h-3 rounded-full transition"
                        :class="current === {{ $index }} ? 'bg-blue' : 'bg-gray-400'">
                    </button>
                @endforeach
            </div>

        </div>
        {{-- ---------------------------------------------------------------- --}}
        {{-- FINE CAROUSEL --}}
        {{-- ---------------------------------------------------------------- --}}

        {{-- Fullscreen gallery --}}
        <div x-show="fullscreen" x-transition class="fixed inset-0 bg-black/90 flex items-center justify-center z-50"
            @click="fullscreen = false" x-cloak>
            <img :src="images[fullscreenIndex]" class="max-w-full max-h-full object-contain">
        </div>

        {{-- Descrizione --}}
        <p class="text-lg leading-relaxed mb-10">
            {{ $car->description }}
        </p>

        {{-- Autore annuncio --}}
        <p class="text-gray-700">
            Pubblicato da:
            <strong>{{ $car->user->name }}</strong>
        </p>

    </div>

</x-layout>
