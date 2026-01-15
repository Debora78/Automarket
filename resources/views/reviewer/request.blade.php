<x-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-900">


        <div class="max-w-xl mx-auto my-20 bg-gray-900 border border-green-400 rounded-lg p-6 shadow-lg">

            <h1 class="text-2xl text-center font-bold text-green-400 mb-4">Diventa revisore</h1>

            <p class="text-gray-300 mb-6">
                Inserisci la tua email per inviare la richiesta. Un amministratore la valuterà e ti contatterà.
            </p>

            {{-- Messaggio di successo --}}
            @if (session('revisor_request_success'))
                <div class="bg-green-600 text-white px-4 py-2 rounded mb-4">
                    {{ session('revisor_request_success') }}
                </div>
            @endif

            {{-- Form richiesta revisore --}}
            <form method="POST" action="{{ route('revisor.request') }}">
                @csrf

                <label for="email" class="block text-sm text-gray-200 mb-1">Email</label>
                <input type="email" name="email" id="email" required
                    class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-green-400
                       focus:outline-none focus:ring focus:ring-green-500">

                {{-- Errori validazione --}}
                @error('email')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror

                <button type="submit"
                    class="mt-4 w-full bg-green-600 hover:bg-green-500 text-white font-semibold py-2 rounded transition">
                    Invia richiesta
                </button>
            </form>
        </div>
    </div>

</x-layout>
