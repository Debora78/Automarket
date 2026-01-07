<x-layout>

    <div class="container mx-auto mt-10">

        <h1 class="text-3xl font-bold mb-6">Annunci da revisionare</h1>

        @if (session('success'))
            <p class="text-green mb-4">{{ session('success') }}</p>
        @endif

        @forelse ($cars as $car)
            <div class="bg-white shadow rounded p-6 mb-6">

                <h2 class="text-2xl font-bold">{{ $car->title }}</h2>
                <p class="text-gray-600">{{ $car->category->name }}</p>
                <p class="mt-2">{{ $car->description }}</p>

                <div class="grid grid-cols-3 gap-4 mt-4">
                    @foreach ($car->images as $image)
                        <img src="{{ asset('storage/' . $image->path) }}" class="rounded shadow h-40 w-full object-cover">
                    @endforeach
                </div>

                <div class="flex gap-4 mt-6">
                    <form action="{{ route('revisor.accept', $car) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button class="bg-green text-white px-4 py-2 rounded">Approva</button>
                    </form>

                    <form action="{{ route('revisor.reject', $car) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red text-white px-4 py-2 rounded">Rifiuta</button>
                    </form>
                </div>

            </div>
        @empty
            <p class="text-gray-600">Nessun annuncio da revisionare.</p>
        @endforelse

    </div>

</x-layout>
