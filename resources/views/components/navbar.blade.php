<nav id="navbar"
    class="fixed top-0 left-0 w-full z-50 bg-gray-900 bg-opacity-80 backdrop-blur-md border-b-2 border-green-400 custom-navbar-glow">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">

        <!-- LOGO -->
        <a href="{{ route('homepage') }}" class="text-2xl font-bold text-green-400">
            AutoMarket
        </a>

        <!-- MENU -->
        <div class="flex items-center space-x-6">

            <a href="{{ route('cars.index', ['type' => 'sale_new']) }}" class="text-gray-200 hover:text-green-400">
                Auto nuove
            </a>

            <a href="{{ route('cars.index', ['type' => 'sale_used']) }}" class="text-gray-200 hover:text-green-400">
                Auto usate
            </a>

            <a href="{{ route('cars.index', ['type' => 'rental']) }}" class="text-gray-200 hover:text-green-400">
                Noleggio
            </a>

            @auth
                <a href="{{ route('cars.create') }}" class="text-gray-200 hover:text-green-400">
                    Inserisci annuncio
                </a>
            @endauth

            <!-- DROPDOWN UTENTE -->
            @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 text-gray-200 hover:text-green-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A9 9 0 1118.88 6.196 9 9 0 015.12 17.804z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>{{ Auth::user()->name }}</span>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-40 bg-gray-800 border border-green-400 rounded shadow-md z-50">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-gray-200 hover:bg-gray-700 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5" />
                                </svg>
                                Esci
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 text-gray-200 hover:text-green-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A9 9 0 1118.88 6.196 9 9 0 015.12 17.804z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 0z" />
                        </svg>
                        <span>Utente</span>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-40 bg-gray-800 border border-green-400 rounded shadow-md z-50">
                        <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-200 hover:bg-gray-700">
                            Accedi
                        </a>
                        <a href="{{ route('register') }}" class="block px-4 py-2 text-gray-200 hover:bg-gray-700">
                            Registrati
                        </a>
                    </div>
                </div>
            @endauth

        </div>
    </div>
</nav>
