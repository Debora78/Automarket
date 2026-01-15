@props(['active'])

@php
    $classes = $active
        ? 'inline-flex items-center px-3 py-2 rounded-md bg-green-600 text-sm font-medium text-white shadow-[0_0_8px_rgba(0,255,0,0.4)] transition duration-150 ease-in-out'
        : 'inline-flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:bg-green-600 hover:text-white transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
