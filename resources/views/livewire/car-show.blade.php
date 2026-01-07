<div class="container mx-auto px-4 py-8">

    <h1 class="text-3xl font-bold mb-4">{{ $car->brand }} {{ $car->model }}</h1>

    <img src="{{ asset('storage/cars/' . $car->image) }}" class="w-full max-w-2xl rounded shadow mb-6">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div>
            <h2 class="text-xl font-semibold mb-2">Dettagli</h2>
            <ul class="space-y-1 text-gray-700">
                <li><strong>Anno:</strong> {{ $car->year }}</li>
                <li><strong>Colore:</strong> {{ $car->color }}</li>
                <li><strong>Prezzo:</strong> € {{ number_format($car->price, 0, ',', '.') }}</li>
                <li><strong>Categoria:</strong> {{ $car->category->name }}</li>
            </ul>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-2">Accessori</h2>
            <ul class="space-y-1 text-gray-700">
                @foreach ($car->accessories as $acc)
                    <li>• {{ $acc }}</li>
                @endforeach
            </ul>
        </div>

    </div>

    <div class="mt-8">
        @if ($car->listing_type === 'rental')
            <a href="#" class="px-6 py-3 bg-blue text-white rounded font-semibold hover:bg-blue-700">
                Noleggia
            </a>
        @else
            <a href="#" class="px-6 py-3 bg-green-600 text-white rounded font-semibold hover:bg-green-700">
                Acquista
            </a>
        @endif
    </div>

</div>
