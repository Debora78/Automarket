@php
    $colors = [
        'sale_new' => 'from-green-400 to-green-600',
        'sale_used' => 'from-blue-400 to-blue-600',
        'rental' => 'from-yellow-400 to-yellow-600',
    ];
@endphp

<span
    class="px-3 py-1 text-sm font-semibold text-white rounded-full bg-gradient-to-r {{ $colors[$type] ?? 'from-gray-400 to-gray-600' }}">
    {{ $slot }}
</span>
