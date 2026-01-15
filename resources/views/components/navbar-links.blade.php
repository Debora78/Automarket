{{-- ============================================================
COMPONENTE: NAVBAR-LINKS (Automarket)
Contiene tutti i link della navbar, sia desktop che mobile.
Usa <x-nav-link> per stile neon + stato attivo automatico.
============================================================ --}}

{{-- Auto nuove --}}
<x-nav-link href="{{ route('cars.index', ['type' => 'sale_new']) }}" :active="request()->fullUrlIs('*sale_new*')">
    Auto nuove
</x-nav-link>

{{-- Auto usate --}}
<x-nav-link href="{{ route('cars.index', ['type' => 'sale_used']) }}" :active="request()->fullUrlIs('*sale_used*')">
    Auto usate
</x-nav-link>

{{-- Noleggio --}}
<x-nav-link href="{{ route('cars.index', ['type' => 'rental']) }}" :active="request()->fullUrlIs('*rental*')">
    Noleggio
</x-nav-link>

{{-- Inserisci annuncio --}}
@auth
    <x-nav-link href="{{ route('cars.create') }}" :active="request()->routeIs('cars.create')">
        Inserisci annuncio
    </x-nav-link>
@endauth

{{-- Dashboard Admin (solo admin) --}}
@auth
    @if (Auth::user()->role === 'admin')
        <x-nav-link href="{{ route('admin.reviewer.index') }}" :active="request()->routeIs('admin.reviewer.index')">
            Dashboard Admin
        </x-nav-link>
    @endif
@endauth



{{-- Carrello --}}
<x-nav-link href="{{ route('cart.index') }}" :active="request()->routeIs('cart.index')">
    <span class="relative">
        🛒
        @if (session('cart_count', 0) > 0)
            <span class="absolute -top-2 -right-2 bg-green-500 text-xs text-white rounded-full px-2 py-0.5">
                {{ session('cart_count') }}
            </span>
        @endif
    </span>
</x-nav-link>

{{-- MENU UTENTE --}}
@include('components.navbar-user')

{{-- Notifiche --}}
@auth
    <x-nav-link href="{{ route('notifications.index') }}" :active="request()->routeIs('notifications.index')">
        <span class="relative">
            🔔
            @if (Auth::user()->unreadNotifications->count() > 0)
                <span class="absolute -top-1 -right-1 bg-green-500 text-xs px-1 rounded-full animate-ping-slow">
                    {{ Auth::user()->unreadNotifications->count() }}
                </span>
            @endif
        </span>
    </x-nav-link>
@endauth
