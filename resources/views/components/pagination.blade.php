@if ($paginator->hasPages())
    <div class="flex justify-center mt-10">
        <div class="flex space-x-2">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-2 bg-gray-700 text-gray-500 rounded cursor-not-allowed">«</span>
            @else
                <button wire:click="previousPage"
                    class="px-3 py-2 bg-gray-800 text-white rounded hover:bg-green-600 transition">«</button>
            @endif

            {{-- Page numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-3 py-2 text-gray-500">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-2 bg-green-600 text-white rounded">{{ $page }}</span>
                        @else
                            <button wire:click="gotoPage({{ $page }})"
                                class="px-3 py-2 bg-gray-800 text-white rounded hover:bg-green-600 transition">
                                {{ $page }}
                            </button>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <button wire:click="nextPage"
                    class="px-3 py-2 bg-gray-800 text-white rounded hover:bg-green-600 transition">»</button>
            @else
                <span class="px-3 py-2 bg-gray-700 text-gray-500 rounded cursor-not-allowed">»</span>
            @endif

        </div>
    </div>
@endif
