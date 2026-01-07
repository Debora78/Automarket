<div
    class="bg-gray-800 rounded-lg shadow-lg overflow-hidden custom-navbar-glow hover:scale-[1.02] transition-transform duration-300">

    {{-- Immagine auto --}}
    <img src="{{ $car->images->isNotEmpty() ? asset('storage/' . $car->images->first()->path) : asset('img/default-car.jpg') }}"
        alt="{{ $car->brand }} {{ $car->model }}" class="w-full h-48 object-cover" />

    <div class="p-4 text-white">

        {{-- Titolo --}}
        <h3
            class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-400 via-green-500 to-green-600">
            {{ $car->brand }} {{ $car->model }}
        </h3>

        {{-- Prezzo --}}
        <p class="text-lg font-semibold mt-2">
            € {{ number_format($car->price, 0, ',', '.') }}
        </p>

        {{-- Info rapide --}}
        <p class="text-sm text-gray-300 mt-1">
            {{ $car->year }} • {{ $car->color }} • {{ $car->category->name }}
        </p>

        {{-- Pulsante --}}
        <a href="{{ route('cars.show', $car) }}"
            class="mt-4 inline-block w-full text-center bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded transition">
            Dettagli
        </a>
    </div>
</div>
