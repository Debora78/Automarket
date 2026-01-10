{{-- 
Componente Blade/Livewire: Paginazione personalizzata Automarket

Funzionalità:
- Mostra i controlli di paginazione solo se ci sono più pagine
- Bottoni Previous / Next con stato disabilitato quando necessario
- Numeri di pagina con evidenziazione della pagina corrente
- Integrazione con Livewire:
    • previousPage()
    • nextPage()
    • gotoPage($page)
- Stile dark + verde neon coerente con il tema Automarket
--}}

@if ($paginator->hasPages())
    <div class="flex justify-center mt-10">
        <div class="flex space-x-2">

            {{-- Bottone PREVIOUS --}}
            @if ($paginator->onFirstPage())
                {{-- Disabilitato --}}
                <span class="px-3 py-2 bg-gray-700 text-gray-500 rounded cursor-not-allowed">«</span>
            @else
                {{-- Attivo --}}
                <button wire:click="previousPage"
                    class="px-3 py-2 bg-gray-800 text-white rounded hover:bg-green-600 transition">
                    «
                </button>
            @endif

            {{-- Numeri di pagina --}}
            @foreach ($elements as $element)
                {{-- Separatore "..." --}}
                @if (is_string($element))
                    <span class="px-3 py-2 text-gray-500">{{ $element }}</span>
                @endif

                {{-- Array di pagine --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        {{-- Pagina corrente --}}
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-2 bg-green-600 text-white rounded">
                                {{ $page }}
                            </span>

                            {{-- Altre pagine --}}
                        @else
                            <button wire:click="gotoPage({{ $page }})"
                                class="px-3 py-2 bg-gray-800 text-white rounded hover:bg-green-600 transition">
                                {{ $page }}
                            </button>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Bottone NEXT --}}
            @if ($paginator->hasMorePages())
                {{-- Attivo --}}
                <button wire:click="nextPage"
                    class="px-3 py-2 bg-gray-800 text-white rounded hover:bg-green-600 transition">
                    »
                </button>
            @else
                {{-- Disabilitato --}}
                <span class="px-3 py-2 bg-gray-700 text-gray-500 rounded cursor-not-allowed">»</span>
            @endif

        </div>
    </div>
@endif
