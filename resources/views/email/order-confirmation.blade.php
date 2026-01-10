{{-- 
Template: Riepilogo ordine (email o pagina di conferma)

Funzionalità:
- Mostra un messaggio di ringraziamento
- Elenca gli articoli acquistati (brand, modello, prezzo)
- Mostra il totale finale
- Messaggio conclusivo per il cliente

Nota:
- Perfetto per email Blade Mailable o pagina di conferma ordine
--}}

<h2 class="text-2xl font-bold text-green-500 mb-4">
    Grazie per il tuo ordine!
</h2>

<p class="mb-4 text-gray-300">
    Ecco il riepilogo:
</p>

<ul class="mb-6 space-y-2 text-gray-200">
    @foreach ($items as $item)
        <li>
            {{ $item->car->brand }} {{ $item->car->model }} —
            <span class="text-green-400 font-semibold">€ {{ number_format($item->car->price, 2, ',', '.') }}</span>
        </li>
    @endforeach
</ul>

<p class="text-lg text-white mb-4">
    <strong>Totale:</strong>
    <span class="text-green-400 font-bold">€ {{ number_format($total, 2, ',', '.') }}</span>
</p>

<p class="text-gray-300 mb-2">
    Ti contatteremo presto per i dettagli.
</p>

<p class="text-green-400 font-semibold">
    Grazie per aver scelto AutoMarket!
</p>
