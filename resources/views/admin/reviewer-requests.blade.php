<x-layout>

    <div class="container mx-auto py-10">

        <h1 class="text-3xl font-bold text-green-400 mb-6">
            Richieste Revisore
        </h1>

        @if ($requests->isEmpty())
            <p class="text-gray-300 text-lg">
                Nessuna richiesta al momento.
            </p>
        @else
            <div class="overflow-x-auto bg-gray-900 border border-green-400 rounded-lg shadow-lg">
                <table class="min-w-full text-left text-gray-200">
                    <thead class="bg-gray-800 border-b border-green-400">
                        <tr>
                            <th class="px-6 py-3">ID</th>
                            <th class="px-6 py-3">Nome</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">Data richiesta</th>
                            <th class="px-6 py-3">Azione</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($requests as $request)
                            <tr class="border-b border-gray-700 hover:bg-gray-800 transition">
                                <td class="px-6 py-4">{{ $request->id }}</td>
                                <td class="px-6 py-4">{{ $request->name }}</td>
                                <td class="px-6 py-4">{{ $request->email }}</td>
                                <td class="px-6 py-4">{{ $request->created_at->format('d/m/Y H:i') }}</td>

                                <td class="px-6 py-4 flex gap-3">

                                    {{-- ACCETTA --}}
                                    <form action="{{ route('admin.reviewer.accept', $request->id) }}" method="POST">
                                        @csrf
                                        <button
                                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded shadow">
                                            Accetta
                                        </button>
                                    </form>

                                    {{-- RIFIUTA --}}
                                    <form action="{{ route('admin.reviewer.reject', $request->id) }}" method="POST">
                                        @csrf
                                        <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded shadow">
                                            Rifiuta
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        @endif

    </div>

</x-layout>
