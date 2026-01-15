<x-layout>
    <div class="max-w-4xl mx-auto py-10">

        {{-- Titolo pagina --}}
        <h1 class="text-2xl font-bold text-green-400 mb-6">Richieste Revisore</h1>

        {{-- Caso: nessuna richiesta in attesa --}}
        @if ($requests->isEmpty())
            <p class="text-gray-300">Nessuna richiesta in attesa.</p>

            {{-- Caso: ci sono richieste --}}
        @else
            <div class="space-y-4">
                @foreach ($requests as $req)
                    {{-- Singola richiesta --}}
                    <div class="bg-gray-800 p-4 rounded flex justify-between items-center">

                        {{-- Dati utente che ha fatto richiesta --}}
                        <div>
                            <p class="text-white font-semibold">{{ $req->user->name }}</p>
                            <p class="text-gray-400 text-sm">{{ $req->user->email }}</p>
                        </div>

                        {{-- Pulsanti azione: accetta / rifiuta --}}
                        <div class="flex gap-3">

                            {{-- Accetta richiesta --}}
                            <form action="{{ route('admin.reviewer.accept', $req->id) }}" method="POST">
                                @csrf
                                <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                                    Accetta
                                </button>
                            </form>

                            {{-- Rifiuta richiesta --}}
                            <form action="{{ route('admin.reviewer.reject', $req->id) }}" method="POST">
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
</x-layout>
