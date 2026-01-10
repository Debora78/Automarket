{{-- 
Pagina indice delle auto.
Utilizza il layout principale e include il componente Livewire
che gestisce la lista, i filtri e la paginazione delle auto.
--}}

<x-layout>
    <div class="container mx-auto mt-10">
        {{-- Componente Livewire che mostra l’elenco delle auto --}}
        <livewire:car-index />
    </div>
</x-layout>
