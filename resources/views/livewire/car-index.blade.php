{{-- 
Pagina: Lista auto con filtri + ricerca (Automarket)

Funzionalità:
- Layout full-screen dark
- Titolo principale con stile neon
- Barra di ricerca Livewire
- Filtri dinamici (categorie + tipo vendita/noleggio)
- Stato vuoto se nessun risultato
- Griglia responsive di card auto
- Paginazione personalizzata

Componenti utilizzati:
- <x-page-title>
- <x-search-bar>
- <x-car-filters>
- <x-empty-state>
- <x-car-card>
- <x-pagination>
--}}

<div class="min-h-screen bg-gray-900 text-white py-8 px-4">
    <div class="max-w-6xl mx-auto mt-20">

        {{-- Titolo pagina --}}
        <x-page-title>
            Trova la tua auto ideale
        </x-page-title>

        {{-- Barra di ricerca --}}
        <x-search-bar />

        {{-- Filtri auto --}}
        <x-car-filters :categories="$categories" :filter_type="$filter_type" />

        {{-- Risultati --}}
        @if ($cars->isEmpty())

            {{-- Nessun risultato --}}
            <x-empty-state />
        @else
            {{-- Griglia auto --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($cars as $car)
                    <x-car-card :car="$car" />
                @endforeach
            </div>

            {{-- Paginazione --}}
            <x-pagination :paginator="$cars" />

        @endif

    </div>
</div>
