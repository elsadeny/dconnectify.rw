@props(['href', 'label', 'icon'])

<a href="{{ $href }}" target="_blank" rel="noreferrer" aria-label="{{ $label }}" title="{{ $label }}"
    class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-white/10 text-white/65 transition hover:border-white/25 hover:bg-white/8 hover:text-white focus:outline-none focus:ring-2 focus:ring-[var(--color-ocean)]">
    @switch($icon)
        @case('whatsapp')
            <svg viewBox="0 0 24 24" class="h-4.5 w-4.5 fill-current" aria-hidden="true">
                <path d="M12.04 2a9.84 9.84 0 0 0-8.44 14.9L2 22l5.23-1.55A9.92 9.92 0 1 0 12.04 2Zm5.78 13.95c-.24.68-1.4 1.3-1.94 1.38-.5.08-1.14.12-1.84-.12-.42-.14-.97-.32-1.67-.62-2.94-1.27-4.85-4.23-5-4.43-.14-.2-1.19-1.58-1.19-3.01 0-1.44.75-2.14 1.02-2.44.27-.3.59-.37.79-.37h.57c.18 0 .43-.07.67.51.25.6.85 2.07.92 2.22.08.15.13.32.03.52-.1.2-.15.32-.3.5-.15.17-.31.38-.45.51-.15.15-.3.31-.13.61.17.3.75 1.24 1.61 2 .1.09 1.54 1.35 3.16 1.86.3.1.53.08.73-.12.2-.2.85-.99 1.07-1.33.22-.35.45-.29.75-.18.3.12 1.92.91 2.25 1.07.33.17.55.25.63.39.08.15.08.84-.16 1.55Z" />
            </svg>
            @break
        @case('facebook')
            <svg viewBox="0 0 24 24" class="h-4.5 w-4.5 fill-current" aria-hidden="true">
                <path d="M24 12.07C24 5.4 18.63 0 12 0S0 5.4 0 12.07C0 18.1 4.39 23.1 10.13 24v-8.44H7.08v-3.49h3.05V9.41c0-3.03 1.79-4.7 4.53-4.7 1.31 0 2.68.24 2.68.24v2.96h-1.51c-1.49 0-1.96.93-1.96 1.89v2.27h3.33l-.53 3.49h-2.8V24C19.61 23.1 24 18.1 24 12.07Z" />
            </svg>
            @break
        @case('instagram')
            <svg viewBox="0 0 24 24" class="h-4.5 w-4.5 fill-none stroke-current" stroke-width="1.8" aria-hidden="true">
                <rect x="3" y="3" width="18" height="18" rx="5" />
                <circle cx="12" cy="12" r="4" />
                <circle cx="17.5" cy="6.5" r="1" class="fill-current stroke-none" />
            </svg>
            @break
        @case('x')
            <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current" aria-hidden="true">
                <path d="M18.9 2h3.68l-8.04 9.19L24 22h-7.41l-5.8-7.59L4.15 22H.46l8.62-9.85L0 2h7.59l5.24 6.93L18.9 2Zm-1.29 18.1h2.04L6.48 3.8H4.29L17.61 20.1Z" />
            </svg>
            @break
    @endswitch
</a>
