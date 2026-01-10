{{-- 
Componente: Messaggio "Nessun risultato"
Scopo:
- Mostrare un feedback elegante quando la ricerca o i filtri non restituiscono auto
- Mantiene lo stile Automarket (verde neon + dark mode)
- Include emoji, titolo e suggerimento per l’utente
--}}

<div class="text-center py-20 text-gray-300">

    {{-- Emoji con glow verde --}}
    <div class="text-5xl mb-4 drop-shadow-[0_0_20px_#22c55e]">
        😕
    </div>

    {{-- Titolo principale con gradiente verde --}}
    <h2
        class="text-3xl font-bold text-transparent bg-clip-text 
           bg-gradient-to-r from-green-400 via-green-500 to-green-600">
        Nessun risultato trovato
    </h2>

    {{-- Testo descrittivo --}}
    <p class="mt-2 text-gray-400">
        Prova a modificare i filtri o cerca un’altra auto.
    </p>

</div>
