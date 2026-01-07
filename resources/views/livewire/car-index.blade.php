<div>
    <x-layout>
        <div class="min-h-screen bg-gray-900 text-white py-8 px-4">
            <div class="max-w-6xl mx-auto mt-20">

                <x-page-title>
                    Trova la tua auto ideale
                </x-page-title>

                <x-search-bar />

                <x-car-filters :categories="$categories" :filter_type="$filter_type" />
                @if ($cars->isEmpty())
                    <x-empty-state />
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($cars as $car)
                            <x-car-card :car="$car" />
                        @endforeach
                    </div>

                    <x-pagination :paginator="$cars" />
                @endif
            </div>
        </div>
    </x-layout>
</div>
