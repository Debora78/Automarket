<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-12 space-y-12">

        <!-- Titolo animato -->
        <x-typewriter-title :text="'Benvenuta in Automarket, ' . Auth::user()->name . '!'" />

        <!-- Card orizzontale -->
        <div class="bg-gray-800 rounded-xl shadow-xl p-10 flex flex-col md:flex-row items-center justify-between gap-10">

            <!-- Sezione sinistra -->
            <div class="flex-1 text-center md:text-left">
                <h2
                    class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-400 via-green-500 to-green-600 drop-shadow-[0_0_20px_#22c55e] mb-4">
                    Il tuo viaggio inizia qui 🚗
                </h2>
                <p class="text-gray-300 text-sm leading-relaxed">
                    Esplora auto nuove, usate o a noleggio.
                    Personalizza la tua esperienza e trova l’auto perfetta per te.
                </p>
            </div>

            <!-- Sezione destra: pulsanti -->
            <div class="flex-1 flex flex-col gap-4 w-full">
                <a href="{{ route('cars.index', ['type' => 'sale_new']) }}"
                    class="block text-center bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg shadow">
                    Auto nuove
                </a>
                <a href="{{ route('cars.index', ['type' => 'sale_used']) }}"
                    class="block text-center bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg shadow">
                    Auto usate
                </a>
                <a href="{{ route('cars.index', ['type' => 'rental']) }}"
                    class="block text-center bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg shadow">
                    Noleggio
                </a>
            </div>
        </div>

        <!-- Box auto preferite -->
        <div class="bg-gray-900 rounded-xl shadow-xl p-8">
            <h3 class="text-xl font-bold text-green-400 mb-6 text-center md:text-left">
                Le tue auto preferite 💚
            </h3>

            @if ($favorites->isEmpty())
                <p class="text-gray-400 text-sm text-center">Non hai ancora aggiunto auto ai preferiti.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach ($favorites as $car)
                        <div class="bg-gray-800 rounded-lg shadow p-4 flex flex-col">
                            <img src="{{ $car->image_url }}" alt="{{ $car->brand }} {{ $car->model }}"
                                class="rounded mb-4 h-40 object-cover">
                            <h4 class="text-green-400 font-semibold text-lg">{{ $car->brand }} {{ $car->model }}
                            </h4>
                            <p class="text-gray-300 text-sm">{{ $car->price }} €</p>
                            <a href="{{ route('cars.show', $car->id) }}"
                                class="mt-auto text-sm text-green-400 hover:underline">
                                Vedi dettagli →
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Pulsante richiesta revisore -->
        @if (!Auth::user()->isReviewer() && !Auth::user()->isAdmin())
            <div class="text-center mt-6">
                <form action="{{ route('reviewer.request') }}" method="POST">
                    @csrf
                    <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        Richiedi di diventare revisore
                    </button>
                </form>
            </div>
        @endif



    </div>
</x-app-layout>
