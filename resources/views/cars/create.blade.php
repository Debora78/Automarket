{{-- 
Pagina per la creazione di una nuova auto.
Utilizza il layout principale dell’app e include il componente Livewire
responsabile della logica e del form di inserimento.
--}}

<x-layout>
    <div class="container mx-auto mt-10">
        {{-- Componente Livewire che gestisce la creazione dell’auto --}}
        <livewire:create-car />
    </div>
</x-layout>
