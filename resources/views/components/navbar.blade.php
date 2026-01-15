<nav id="navbar" x-data="{ open: false }"
    class="fixed top-0 left-0 w-full z-50 bg-gray-900 bg-opacity-80 backdrop-blur-md border-b-2 border-green-400 custom-navbar-glow">

    <div class="container mx-auto px-4 py-4 flex justify-between items-center">

        {{-- LOGO --}}
        <a href="{{ route('homepage') }}" class="text-2xl font-bold text-green-400">
            AutoMarket
        </a>

        {{-- Hamburger menu (mobile) --}}
        <button @click="open = !open" class="md:hidden text-gray-200 hover:text-green-400 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        {{-- MENU DESKTOP --}}
        <div class="hidden md:flex items-center space-x-6">
            @include('components.navbar-links')
        </div>
    </div>

    {{-- MENU MOBILE --}}
    <div x-show="open" x-transition class="md:hidden px-4 pb-4 space-y-4">
        @include('components.navbar-links')
    </div>
</nav>
