@props(['text'])

<div class="relative w-full overflow-x-hidden whitespace-nowrap mb-8 py-2">
    <div class="flex animate-marquee gap-16">
        <span
            class="text-4xl md:text-5xl font-extrabold leading-relaxed
                     text-transparent bg-clip-text bg-gradient-to-r from-green-400 via-green-500 to-green-600
                     drop-shadow-[0_0_25px_#22c55e]">
            {{ $text }}
        </span>

        <span
            class="text-4xl md:text-5xl font-extrabold leading-relaxed
                     text-transparent bg-clip-text bg-gradient-to-r from-green-400 via-green-500 to-green-600
                     drop-shadow-[0_0_25px_#22c55e]">
            {{ $text }}
        </span>
    </div>
</div>
