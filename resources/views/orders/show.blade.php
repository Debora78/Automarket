{{-- 
Pagina: Dettaglio ordine (Automarket)

Funzionalità:
- Mostra le informazioni principali dell’ordine selezionato
- Visualizza stato, data, articoli acquistati e totale
- Ogni articolo mostra marca, modello e prezzo
- Pulsante per tornare alla lista ordini
- Stile coerente con il tema dark + verde Automarket
--}}

<x-app-layout>
    <div class="max-w-4xl mx-auto py-10">

        {{-- Titolo --}}
        <h1 class="text-3xl font-bold text-green-400 mb-6">
            Dettaglio ordine {{ $order->order_number }}
        </h1>

        {{-- Stato --}}
        <p class="text-gray-300 mb-4">
            Stato:
            <span class="font-semibold text-green-400">
                {{ str_replace('_', ' ', ucfirst($order->status)) }}
            </span>
        </p>

        {{-- Data --}}
        <p class="text-gray-300 mb-4">
            Data: {{ $order->created_at->format('d/m/Y H:i') }}
        </p>

        {{-- Articoli --}}
        <h2 class="text-xl font-semibold text-white mb-3">Articoli acquistati</h2>

        <div class="space-y-4">
            @foreach ($order->items as $item)
                <div class="bg-gray-800 p-4 rounded flex justify-between items-center">
                    <div>
                        <p class="text-white font-semibold">
                            {{ $item->car->brand }} {{ $item->car->model }}
                        </p>
                        <p class="text-gray-400 text-sm">
                            € {{ number_format($item->price, 2, ',', '.') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <hr class="my-6 border-gray-700">

        {{-- Totale --}}
        <p class="text-xl text-green-400 font-bold">
            Totale: € {{ number_format($order->total, 2, ',', '.') }}
        </p>

        {{-- Torna indietro --}}
        <a href="{{ route('orders.index') }}"
            class="inline-block mt-6 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded">
            Torna ai miei ordini
        </a>

    </div>
</x-app-layout>
