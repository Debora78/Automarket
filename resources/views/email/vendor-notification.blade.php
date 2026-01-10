{{-- 
Template: Notifica vendita veicolo (email o dashboard)

Funzionalità:
- Comunica al venditore che un suo veicolo è stato acquistato
- Mostra numero ordine, dati del veicolo e prezzo formattato
- Invita ad accedere alla dashboard per ulteriori dettagli
--}}

<h2 class="text-2xl font-bold text-green-500 mb-4">
    Hai venduto un veicolo!
</h2>

<p class="text-gray-300 mb-2">
    <strong>Ordine:</strong> {{ $order->order_number }}
</p>

<p class="text-gray-200 mb-4">
    <strong>Veicolo:</strong> {{ $car->brand }} {{ $car->model }}<br>
    <strong>Prezzo:</strong>
    <span class="text-green-400 font-semibold">
        € {{ number_format($car->price, 2, ',', '.') }}
    </span>
</p>

<p class="text-gray-300 mb-2">
    Accedi alla tua dashboard per maggiori dettagli.
</p>

<p class="text-green-400 font-semibold">
    Grazie per utilizzare la nostra piattaforma!
</p>
