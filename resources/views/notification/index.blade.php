{{-- 
Pagina: Lista notifiche utente (Automarket)

Funzionalità:
- Mostra tutte le notifiche dell’utente autenticato
- Permette di segnarle come lette singolarmente o tutte insieme
- Permette di eliminarle singolarmente o tutte insieme
- Evidenzia le notifiche non lette con bordo verde
- Layout coerente con il tema dark Automarket
--}}

<x-layout>
    <div class="max-w-3xl mx-auto py-10">

        <h1 class="text-2xl font-bold text-green-400 mb-6">Le tue notifiche</h1>

        <div class="flex gap-4 mb-6">
            <form action="{{ route('notifications.markAllRead') }}" method="POST">
                @csrf
                <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    Segna tutte come lette
                </button>
            </form>

            <form action="{{ route('notifications.deleteAll') }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                    Elimina tutte
                </button>
            </form>
        </div>

        @if (Auth::user()->notifications->isEmpty())
            <p class="text-gray-400">Non hai notifiche al momento.</p>
        @else
            <div class="space-y-4">

                @foreach (Auth::user()->notifications as $notification)
                    <div class="flex items-start gap-3">

                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST"
                            class="flex-1">
                            @csrf

                            @if ($notification->read_at)
                                <div class="bg-gray-800 p-4 rounded opacity-60">
                                @else
                                    <div class="bg-gray-800 p-4 rounded border border-green-500 cursor-pointer"
                                        onclick="this.closest('form').submit()">
                            @endif

                            <p class="text-white">{{ $notification->data['message'] }}</p>
                            <span class="text-gray-500 text-xs">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>

                    </div>
                    </form>

                    <form action="{{ route('notifications.delete', $notification->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 text-xl">✖</button>
                    </form>

            </div>
        @endforeach

    </div>
    @endif

    </div>
</x-layout>
