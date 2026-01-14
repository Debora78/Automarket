{{-- 
Pagina: Sicurezza & Password
Funzionalità:
- Cambio password
- Attivazione/disattivazione 2FA
- Codici di recupero
- Stile dark + neon Automarket
--}}

<x-layout>

    <div class="max-w-3xl mx-auto mt-24 bg-gray-900 text-white p-8 rounded-lg shadow-lg border border-green-400">

        {{-- Titolo --}}
        <h1 class="text-3xl font-bold text-green-400 mb-6">
            Sicurezza & Password
        </h1>

        {{-- Messaggi --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-600 text-white rounded-lg shadow">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-600 text-white rounded-lg shadow">
                {{ session('error') }}
            </div>
        @endif

        {{-- Errori --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-600 text-white rounded-lg shadow">
                <ul class="list-disc ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ---------------------------------------------------------
             CAMBIO PASSWORD
           --------------------------------------------------------- --}}
        <h2 class="text-xl font-semibold text-green-300 mb-4">Cambia password</h2>

        <form action="{{ route('password.update') }}" method="POST" class="space-y-4 mb-10">
            @csrf

            <div>
                <label class="block mb-1 text-gray-300">Password attuale</label>
                <input type="password" name="current_password"
                    class="w-full bg-gray-800 border border-gray-700 rounded px-3 py-2 text-white">
            </div>

            <div>
                <label class="block mb-1 text-gray-300">Nuova password</label>
                <input type="password" name="password"
                    class="w-full bg-gray-800 border border-gray-700 rounded px-3 py-2 text-white">
            </div>

            <div>
                <label class="block mb-1 text-gray-300">Conferma nuova password</label>
                <input type="password" name="password_confirmation"
                    class="w-full bg-gray-800 border border-gray-700 rounded px-3 py-2 text-white">
            </div>

            <button class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded text-white font-semibold">
                Aggiorna password
            </button>
        </form>

        {{-- ---------------------------------------------------------
             AUTENTICAZIONE A DUE FATTORI (2FA)
           --------------------------------------------------------- --}}
        <h2 class="text-xl font-semibold text-green-300 mb-4">Autenticazione a due fattori</h2>

        @if (!$user->two_factor_secret)
            {{-- 2FA NON ATTIVA --}}
            <form action="{{ route('2fa.enable') }}" method="POST">
                @csrf
                <button class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded text-white font-semibold">
                    Attiva 2FA
                </button>
            </form>
        @else
            {{-- 2FA ATTIVA --}}
            <p class="mb-4 text-gray-300">La 2FA è attiva sul tuo account.</p>

            {{-- Codici di recupero --}}
            <div class="bg-gray-800 p-4 rounded border border-gray-700 mb-4">
                <h3 class="text-green-400 font-semibold mb-2">Codici di recupero</h3>

                @foreach (json_decode(decrypt($user->two_factor_recovery_codes)) as $code)
                    <div class="text-gray-300">{{ $code }}</div>
                @endforeach
            </div>

            {{-- Rigenera codici --}}
            <form action="{{ route('2fa.recovery') }}" method="POST" class="mb-4">
                @csrf
                <button class="bg-yellow-500 hover:bg-yellow-600 px-4 py-2 rounded text-white font-semibold">
                    Rigenera codici
                </button>
            </form>

            {{-- Disattiva 2FA --}}
            <form action="{{ route('2fa.disable') }}" method="POST">
                @csrf
                <button class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-white font-semibold">
                    Disattiva 2FA
                </button>
            </form>
        @endif

    </div>

</x-layout>
