{{-- ============================================================
COMPONENTE: NAVBAR-USER
Gestisce il menu utente (guest + autenticato)
============================================================ --}}

@guest
    <div class="relative" x-data="{ openUser: false }">
        <button @click="openUser = !openUser"
            class="flex items-center space-x-2 text-gray-200 hover:text-green-400 transition">
            👤 <span>Utente</span>
        </button>

        <div x-show="openUser" @click.away="openUser = false" x-transition
            class="absolute right-0 mt-2 w-40 bg-gray-800 border border-green-400 rounded shadow-md z-50">
            <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-200 hover:bg-gray-700">Accedi</a>
            <a href="{{ route('register') }}" class="block px-4 py-2 text-gray-200 hover:bg-gray-700">Registrati</a>
        </div>
    </div>
@endguest

@auth
    <div class="relative" x-data="{ openUser: false }">
        <button @click="openUser = !openUser"
            class="flex items-center space-x-2 text-gray-200 hover:text-green-400 transition">
            👤 <span>{{ Auth::user()->name }}</span>

            @if (Auth::user()->isRevisor())
                <span class="ml-2 bg-green-600 text-white text-xs px-2 py-1 rounded">Revisore</span>
            @endif
        </button>

        <div x-show="openUser" @click.away="openUser = false" x-transition
            class="absolute right-0 mt-2 w-48 bg-gray-800 border border-green-400 rounded shadow-md z-50">

            {{-- Profilo utente --}}
            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-200 hover:bg-gray-700">
                Profilo utente
            </a>

            {{-- Sicurezza e password --}}
            <a href="{{ route('password.change') }}" class="block px-4 py-2 text-gray-200 hover:bg-gray-700">
                Sicurezza e password
            </a>

            {{-- I miei annunci --}}
            <a href="{{ route('user.cars') }}" class="block px-4 py-2 text-gray-200 hover:bg-gray-700">
                I miei annunci
            </a>

            {{-- Preferiti --}}
            <a href="{{ route('favorites.index') }}" class="block px-4 py-2 text-gray-200 hover:bg-gray-700">
                Preferiti
            </a>

            {{-- Diventa revisore (solo se non lo è già) --}}
            @if (!Auth::user()->isRevisor())
                <a href="{{ route('revisor.form') }}" class="block px-4 py-2 text-gray-200 hover:bg-gray-700">
                    Diventa revisore
                </a>
            @endif

            {{-- Logout dentro la lista --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-gray-200 hover:bg-red-600">
                    Esci
                </button>
            </form>
        </div>
    </div>
@endauth
