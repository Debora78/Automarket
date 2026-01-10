{{-- 
Pagina: Lista ordini dell’utente (Automarket)

Funzionalità:
- Mostra tutti gli ordini effettuati dall’utente autenticato
- Ogni ordine è cliccabile e porta alla pagina dei dettagli
- Visualizza numero ordine, data e totale formattato
- Mostra un messaggio se non ci sono ordini
- Stile coerente con il tema dark + verde Automarket
--}}

<x-app-layout>
    <div class="max-w-4xl mx-auto py-10">

        {{-- Titolo --}}
        <h1 class="text-3xl font-bold text-green-400 mb-6">
            I miei ordini
        </h1>

        {{-- Nessun ordine --}}
        @if ($orders->isEmpty())
            <p class="text-gray-300">Non hai ancora effettuato ordini.</p>

            {{-- Lista ordini --}}
        @else
            <div class="space-y-4">

                @foreach ($orders as $order)
                    <a href="{{ route('orders.show', $order) }}"
                        class="block bg-gray-800 p-4 rounded hover:bg-gray-700 transition">

                        <div class="flex justify-between items-center">

                            <div>
                                <p class="text-white font-semibold">
                                    Ordine: {{ $order->order_number }}
                                </p>

                                <p class="text-gray-400 text-sm">
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>

                            <p class="text-green-400 font-bold text-lg">
                                € {{ number_format($order->total, 2, ',', '.') }}
                            </p>

                        </div>

                    </a>
                @endforeach

            </div>
        @endif

    </div>
</x-app-layout>
