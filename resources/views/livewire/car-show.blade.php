<div class="max-w-5xl mx-auto px-4 py-16 text-white">

    {{-- Titolo --}}
    <h1
        class="text-4xl font-extrabold mb-6 
               text-transparent bg-clip-text 
               bg-gradient-to-r from-green-400 via-green-500 to-green-600
               drop-shadow-[0_0_25px_#22c55e]">
        {{ $car->brand }} {{ $car->model }}
    </h1>

    {{-- Immagine principale --}}
    <img src="{{ asset('storage/cars/' . $car->image) }}"
        class="w-full max-w-3xl rounded-lg shadow-lg mb-10 mx-auto object-cover">

    {{-- Griglia dettagli --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

        {{-- Dettagli --}}
        <div>
            <h2 class="text-2xl font-semibold mb-4 text-green-400">Dettagli</h2>

            <ul class="space-y-2 text-gray-300">
                <li><strong class="text-white">Anno:</strong> {{ $car->year }}</li>
                <li><strong class="text-white">Colore:</strong> {{ $car->color }}</li>
                <li>
                    <strong class="text-white">Prezzo:</strong>
                    <span class="text-green-400 font-bold">
                        € {{ number_format($car->price, 0, ',', '.') }}
                    </span>
                </li>
                <li><strong class="text-white">Categoria:</strong> {{ $car->category->name }}</li>
            </ul>
        </div>

        {{-- Accessori --}}
        <div>
            <h2 class="text-2xl font-semibold mb-4 text-green-400">Accessori</h2>

            <ul class="space-y-2 text-gray-300">
                @foreach ($car->accessories as $acc)
                    <li>• {{ $acc }}</li>
                @endforeach
            </ul>
        </div>

    </div>

    {{-- CTA --}}
    <div class="mt-12">

        @if ($car->listing_type === 'rental')
            <a href="#"
                class="px-8 py-3 bg-blue-600 hover:bg-blue-700 
                      rounded-lg font-semibold text-white 
                      shadow-lg transition">
                Noleggia
            </a>
        @else
            <a href="#"
                class="px-8 py-3 bg-green-600 hover:bg-green-700 
                      rounded-lg font-semibold text-white 
                      shadow-lg transition">
                Acquista
            </a>
        @endif

    </div>

</div>
