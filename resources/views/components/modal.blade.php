{{-- 
Componente Blade: Modal dinamica con Alpine.js

Props:
- name: nome univoco del modal (usato per aprirlo/chiuderlo via eventi)
- show: stato iniziale (true/false)
- maxWidth: larghezza massima del contenitore (sm, md, lg, xl, 2xl)

Funzionalità:
- Apertura/chiusura tramite eventi personalizzati:
    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'modalName' }))
    window.dispatchEvent(new CustomEvent('close-modal', { detail: 'modalName' }))
- Blocca lo scroll della pagina quando il modal è aperto
- Gestione completa del focus (accessibilità):
    • tab → passa al prossimo elemento
    • shift+tab → torna al precedente
    • esc → chiude il modal
- Overlay cliccabile per chiudere
- Transizioni animate per overlay e contenuto
- Supporto dark mode
--}}

@props(['name', 'show' => false, 'maxWidth' => '2xl'])

@php
    // Mappa delle larghezze disponibili
    $maxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
    ][$maxWidth];
@endphp

<div x-data="{
    show: @js($show),

    // Ritorna tutti gli elementi focusabili nel modal
    focusables() {
        let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
        return [...$el.querySelectorAll(selector)]
            .filter(el => !el.hasAttribute('disabled'))
    },

    // Primo elemento focusabile
    firstFocusable() { return this.focusables()[0] },

    // Ultimo elemento focusabile
    lastFocusable() { return this.focusables().slice(-1)[0] },

    // Elemento successivo
    nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },

    // Elemento precedente
    prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },

    // Indice del prossimo elemento
    nextFocusableIndex() {
        return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1)
    },

    // Indice del precedente elemento
    prevFocusableIndex() {
        return Math.max(0, this.focusables().indexOf(document.activeElement)) - 1
    },
}" {{-- Gestione apertura/chiusura e blocco scroll --}} x-init="$watch('show', value => {
    if (value) {
        document.body.classList.add('overflow-y-hidden');
        {{ $attributes->has('focusable') ? 'setTimeout(() => firstFocusable().focus(), 100)' : '' }}
    } else {
        document.body.classList.remove('overflow-y-hidden');
    }
})" {{-- Eventi globali per aprire/chiudere il modal --}}
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
    x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null" {{-- Chiusura tramite overlay, ESC o evento close --}}
    x-on:close.stop="show = false" x-on:keydown.escape.window="show = false" {{-- Gestione tab focus --}}
    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()" {{-- Mostra/nasconde il modal --}} x-show="show"
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50" style="display: {{ $show ? 'block' : 'none' }};">

    {{-- Overlay scuro cliccabile --}}
    <div x-show="show" class="fixed inset-0 transform transition-all" x-on:click="show = false"
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>

    {{-- Contenuto del modal --}}
    <div x-show="show"
        class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        {{ $slot }}
    </div>
</div>
