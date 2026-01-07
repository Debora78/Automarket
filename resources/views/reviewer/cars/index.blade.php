<x-app-layout>
    <div class="max-w-5xl mx-auto py-10">

        <h1 class="text-2xl font-bold text-green-400 mb-6">Annunci in attesa di revisione</h1>

        @if ($cars->isEmpty())
            <p class="text-gray-300">Nessun annuncio in attesa.</p>
        @else
            <div class="space-y-4">
                @foreach ($cars as $car)
                    <div class="bg-gray-800 p-4 rounded flex justify-between items-center">
                        <div>
                            <p class="text-white font-semibold">{{ $car->brand }} {{ $car->model }}</p>
                            <p class="text-gray-400 text-sm">{{ $car->price }} €</p>
                        </div>

                        <div class="flex gap-3">
                            <form action="{{ route('reviewer.cars.approve', $car) }}" method="POST">
                                @csrf
                                <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                                    Approva
                                </button>
                            </form>

                            <form action="{{ route('reviewer.cars.reject', $car) }}" method="POST">
                                @csrf
                                <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                                    Rifiuta
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</x-app-layout>
