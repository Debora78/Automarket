{{-- 
NAVBAR PRINCIPALE DI AUTOMARKET

Funzionalità aggiunte:
- Icona carrello visibile a tutti (guest + utenti)
- Menu utente completo (Profilo, Sicurezza, Annunci, Preferiti, Diventa revisore, Logout)
- Mantiene stile dark + neon verde
--}}

<nav id="navbar"
    class="fixed top-0 left-0 w-full z-50 bg-gray-900 bg-opacity-80 backdrop-blur-md 
       border-b-2 border-green-400 custom-navbar-glow">

    <div class="container mx-auto px-4 py-4 flex justify-between items-center">

        {{-- LOGO --}}
        <a href="{{ route('homepage') }}" class="text-2xl font-bold text-green-400">
            AutoMarket
        </a>

        {{-- MENU PRINCIPALE --}}
        <div class="flex items-center space-x-6">

            {{-- Link auto nuove --}}
            <a href="{{ route('cars.index', ['type' => 'sale_new']) }}" class="text-gray-200 hover:text-green-400">
                Auto nuove
            </a>

            {{-- Link auto usate --}}
            <a href="{{ route('cars.index', ['type' => 'sale_used']) }}" class="text-gray-200 hover:text-green-400">
                Auto usate
            </a>

            {{-- Link noleggio --}}
            <a href="{{ route('cars.index', ['type' => 'rental']) }}" class="text-gray-200 hover:text-green-400">
                Noleggio
            </a>

            {{-- Link inserisci annuncio (solo utenti autenticati) --}}
            @auth
                <a href="{{ route('cars.create') }}" class="text-gray-200 hover:text-green-400">
                    Inserisci annuncio
                </a>
            @endauth

            {{-- ---------------------------------------------------------
                 ICONA CARRELLO (visibile a tutti)
               --------------------------------------------------------- --}}
            <a href="{{ route('cart.index') }}" class="relative text-white hover:text-green-400">

                {{-- Icona carrello --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437m0 0L6.75 14.25h10.5l2.25-8.25H5.106m0 0L4.125 6.75m2.625 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm10.5 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>

                {{-- Badge quantità (opzionale) --}}
                @if (session('cart_count', 0) > 0)
                    <span
                        class="absolute -top-2 -right-2 bg-green-500 text-xs text-white 
                                 rounded-full px-2 py-0.5">
                        {{ session('cart_count') }}
                    </span>
                @endif
            </a>

            {{-- ---------------------------------------------------------
                 DROPDOWN UTENTE (versione loggato)
               --------------------------------------------------------- --}}
            @auth
                <div class="relative" x-data="{ open: false }">

                    {{-- Bottone apertura dropdown --}}
                    <button @click="open = !open" class="flex items-center space-x-2 text-gray-200 hover:text-green-400">

                        {{-- Icona utente --}}
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A9 9 0 1118.88 6.196 9 9 0 015.12 17.804z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>

                        {{-- Nome utente --}}
                        <span>{{ Auth::user()->name }}</span>

                        {{-- Badge revisore --}}
                        @if (Auth::user()->isRevisor())
                            <span class="ml-2 bg-green-600 text-white text-xs px-2 py-1 rounded">
                                Revisore
                            </span>
                        @endif
                    </button>

                    {{-- Menu dropdown --}}
                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-48 bg-gray-800 border border-green-400 
                               rounded shadow-md z-50">

                        {{-- Profilo utente --}}
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-200 hover:bg-gray-700">
                            Profilo utente
                        </a>

                        {{-- Sicurezza e password (Fortify) --}}
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

                        {{-- Diventa revisore --}}
                        @if (!Auth::user()->isRevisor())
                            <form method="POST" action="{{ route('become.revisor') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-gray-200 hover:bg-gray-700">
                                    Diventa revisore
                                </button>
                            </form>
                        @endif

                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-gray-200 hover:bg-red-600 flex items-center">

                                {{-- Icona logout --}}
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5" />
                                </svg>

                                Esci
                            </button>
                        </form>
                    </div>
                </div>

                {{-- ---------------------------------------------------------
                 DROPDOWN UTENTE (versione non loggato)
               --------------------------------------------------------- --}}
            @else
                <div class="relative" x-data="{ open: false }">

                    {{-- Icona utente --}}
                    <button @click="open = !open" class="flex items-center space-x-2 text-gray-200 hover:text-green-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A9 9 0 1118.88 6.196 9 9 0 015.12 17.804z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>

                    {{-- Dropdown login/registrazione --}}
                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-40 bg-gray-800 border border-green-400 
                               rounded shadow-md z-50">

                        <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-200 hover:bg-gray-700">
                            Accedi
                        </a>

                        <a href="{{ route('register') }}" class="block px-4 py-2 text-gray-200 hover:bg-gray-700">
                            Registrati
                        </a>
                    </div>
                </div>
            @endauth

            {{-- NOTIFICHE --}}
            @auth
                <a href="{{ route('notifications.index') }}" class="relative text-white hover:text-green-400">

                    {{-- Icona campanella --}}
                    <span class="text-xl">🔔</span>

                    {{-- Badge notifiche non lette --}}
                    @if (Auth::user()->unreadNotifications->count() > 0)
                        <span class="absolute -top-1 -right-1 bg-green-500 text-xs px-1 rounded-full animate-ping-slow">
                            {{ Auth::user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>
            @endauth

        </div>
    </div>
</nav>
