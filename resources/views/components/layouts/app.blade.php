<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'connectify Marketplace' }}</title>
    <meta name="description"
        content="connectify is a modern East African marketplace for cars, jobs, rentals, services and real estate.">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="16x16 32x32 48x48 64x64 96x96"
        type="image/x-icon">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('images/connectify-logo.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,700|plus-jakarta-sans:400,500,600,700,800"
        rel="stylesheet" />
    <script>
        (() => {
            const storageKey = 'connectify-theme';
            const theme = localStorage.getItem(storageKey) || 'system';
            const hour = new Date().getHours();
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            const isNight = hour >= 18 || hour < 7;
            const resolvedTheme = theme === 'light' ? 'light' : theme === 'dark' ? 'dark' : theme === 'auto' ? (isNight ? 'dark' : 'light') : (prefersDark ? 'dark' : 'light');

            document.documentElement.dataset.theme = resolvedTheme;
            document.documentElement.dataset.themePreference = theme;
            document.documentElement.classList.toggle('dark', resolvedTheme === 'dark');
            document.documentElement.style.colorScheme = resolvedTheme;
        })();
    </script>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Space Grotesk', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <style>
        :root {
            --color-ink: #0a0a0a;
            --color-night: #111111;
            --color-deep: #262626;
            --color-paper: #f5f5f5;
            --color-paper-strong: #ffffff;
            --color-sun: #d4d4d4;
            --color-clay: #525252;
            --color-ocean: #171717;
            --color-leaf: #16956b;
            --color-mist: #ededed;
            --color-sand: #a3a3a3;
            --color-steel: #737373;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--color-paper);
        }

        .premium-hero-bg {
            background:
                radial-gradient(circle at 14% 10%, rgba(255, 255, 255, 0.08), transparent 24%),
                linear-gradient(180deg, #000 0%, var(--color-night) 60%, var(--color-deep) 100%);
        }

        .font-display {
            font-family: 'Space Grotesk', sans-serif;
        }

        .site-shell {
            position: relative;
            min-height: 100vh;
            overflow-x: hidden;
        }

        @media (max-width: 767px) {
            .site-shell {
                padding-bottom: calc(5.75rem + env(safe-area-inset-bottom));
            }
        }

        .site-shell::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: -20;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.025) 1px, transparent 1px),
                linear-gradient(135deg, rgba(255, 255, 255, 0.04), transparent 30%);
            background-size: 78px 78px, 78px 78px, auto;
            -webkit-mask-image: linear-gradient(180deg, black 0%, black 35%, transparent 80%);
            mask-image: linear-gradient(180deg, black 0%, black 35%, transparent 80%);
            pointer-events: none;
        }

        .page-orb {
            position: fixed;
            z-index: -10;
            border-radius: 9999px;
            filter: blur(56px);
            pointer-events: none;
        }

        .glass-panel {
            background: linear-gradient(180deg, rgba(7, 17, 31, 0.90), rgba(4, 9, 20, 0.86));
            border: 1px solid rgba(255, 255, 255, 0.10);
            box-shadow: 0 24px 80px -40px rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(24px);
        }

        .hero-panel {
            background: linear-gradient(180deg, rgba(17, 29, 46, 0.96), rgba(7, 17, 31, 0.95));
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 32px 90px -40px rgba(0, 0, 0, 0.75);
        }

        .surface-card {
            background: linear-gradient(180deg, rgba(248, 251, 255, 0.98), rgba(237, 244, 251, 0.96));
            border: 1px solid #d4d4d4;
            box-shadow: 0 28px 80px -42px rgba(0, 0, 0, 0.35);
        }

        .surface-card-soft {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.95), rgba(232, 242, 252, 0.95));
            border: 1px solid #d4d4d4;
        }

        .section-heading {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.24em;
            color: var(--color-clay);
        }

        .primary-cta {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            padding: 0.75rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.22em;
            color: var(--color-ink);
            background: linear-gradient(135deg, var(--color-ocean), #525252);
            box-shadow: 0 18px 40px -18px rgba(0, 0, 0, 0.5);
        }

        .secondary-cta {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            padding: 0.75rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--color-ink);
            border: 1px solid rgba(255, 255, 255, 0.12);
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.04));
            box-shadow: 0 18px 40px -18px rgba(0, 0, 0, 0.4);
        }

        html[data-theme='dark'] .secondary-cta {
            color: #eaf2ff !important;
            border-color: rgba(255, 255, 255, 0.14) !important;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.03)) !important;
        }

        .gold-chip {
            display: inline-flex;
            border-radius: 9999px;
            border: 1px solid #d4d4d4;
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.18em;
            color: var(--color-clay);
            background: #ededed;
        }

        .dark-stat {
            border-radius: 1.75rem;
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 1.25rem;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.03));
            backdrop-filter: blur(16px);
        }

        html[data-theme='dark'] .connectify-input,
        html[data-theme='dark'] input.connectify-input,
        html[data-theme='dark'] select.connectify-input,
        html[data-theme='dark'] textarea.connectify-input {
            background: rgba(255, 255, 255, 0.1) !important;
            border-color: rgba(255, 255, 255, 0.12) !important;
            color: #eaf2ff !important;
            caret-color: #eaf2ff !important;
        }

        html[data-theme='dark'] .connectify-input::placeholder,
        html[data-theme='dark'] input::placeholder,
        html[data-theme='dark'] textarea::placeholder {
            color: rgba(234, 242, 255, 0.7) !important;
            opacity: 1;
        }

        .connectify-input {
            width: 100%;
            border-radius: 1rem;
            border: 1px solid #d4d4d4;
            background: rgba(255, 255, 255, 0.88);
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            color: #0f172a;
            outline: none;
        }

        .footer-link {
            color: rgba(255, 255, 255, 0.58);
            transition: color 0.2s ease;
        }

        .footer-link:hover {
            color: white;
        }

        .footer-title {
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--color-sand);
        }
    </style>
    @endif
</head>

<body class="bg-[var(--color-paper)] text-[var(--color-ink)] antialiased">
    <div class="page-orb left-[-8rem] top-16 h-64 w-64 bg-black/10"></div>
    <div class="page-orb right-[-7rem] top-28 h-72 w-72 bg-black/5"></div>
    <div class="page-orb bottom-20 left-[20%] h-60 w-60 bg-black/10"></div>
    <div class="site-shell">
        {{ $slot }}

        <footer id="site-footer"
            class="mt-12 hidden border-t border-white/8 bg-[linear-gradient(180deg,rgba(7,17,31,0.96),rgba(4,9,20,1))] md:block">
            <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
                <div class="mb-8 rounded-[2rem] border border-white/8 bg-white/5 p-5 md:p-6">
                    <div class="mb-5">
                        <p class="footer-title">Contact us</p>
                        <h2 class="mt-2 font-display text-2xl font-bold text-white">Choose the right contact for your question.</h2>
                    </div>
                    <div class="grid gap-4 md:grid-cols-3">
                        @foreach ([
                            ['label' => 'General support', 'phone' => '+250 788 881 400', 'number' => '250788881400', 'email' => 'supports@connectify.rw'],
                            ['label' => 'Customer care', 'phone' => '+250 788 888 209', 'number' => '250788888209', 'email' => 'customers@connectify.rw'],
                            ['label' => 'Seller support', 'phone' => '+250 788 888 204', 'number' => '250788888204', 'email' => 'supports@connectify.rw'],
                        ] as $contact)
                        <div class="rounded-[1.5rem] border border-white/10 bg-white/6 px-5 py-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[var(--color-sand)]">{{ $contact['label'] }}</p>
                            <a href="tel:{{ $contact['number'] }}" class="mt-3 block text-lg font-bold text-white hover:text-[var(--color-sand)]">{{ $contact['phone'] }}</a>
                            <a href="mailto:{{ $contact['email'] }}" class="mt-1 block truncate text-sm text-white/58 hover:text-white">{{ $contact['email'] }}</a>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="grid gap-8 border-b border-white/8 pb-8 lg:grid-cols-[1.2fr_0.8fr_0.8fr_0.8fr_0.8fr]">
                    <div>
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('images/connectify-logo.png') }}" alt="Connectify logo"
                                class="h-12 w-12 shrink-0 rounded-full object-cover shadow-[0_14px_35px_-16px_rgba(0,0,0,0.55)]">
                            <div>
                                <p class="font-display text-xl font-bold text-white">connectify.rw</p>
                                <p class="text-xs uppercase tracking-[0.24em] text-white/50">East Africa marketplace</p>
                            </div>
                        </div>
                        <p class="mt-5 max-w-sm text-sm leading-7 text-white/60">connectify is a modern East African
                            marketplace for vehicles, property, jobs, rentals and services, helping people discover
                            trusted listings and connect with sellers faster.</p>
                        <div class="mt-5 flex flex-wrap gap-2">
                            <x-social-icon href="https://wa.me/250788881400" label="WhatsApp" icon="whatsapp" />
                            <x-social-icon href="https://www.facebook.com/haruna.nyamushanja/" label="Facebook" icon="facebook" />
                            <x-social-icon href="https://www.instagram.com/connectify.rw/" label="Instagram" icon="instagram" />
                            <x-social-icon href="https://x.com/CarconnectRw" label="X" icon="x" />
                        </div>
                    </div>

                    <div>
                        <p class="footer-title">Company</p>
                        <div class="mt-4 space-y-3">
                            <a href="{{ route('home') }}#why-connectify" class="footer-link block">About connectify</a>
                            <a href="{{ route('home') }}#featured" class="footer-link block">Featured listings</a>
                            <a href="{{ route('home') }}#latest" class="footer-link block">Latest listings</a>
                            <a href="/seller" class="footer-link block">Seller Panel</a>
                            <a href="/seller/register" class="footer-link block">Become a seller</a>
                            <a href="https://wa.me/250788881400?text=Hi%2C%20I%20need%20support" target="_blank"
                                rel="noreferrer" class="footer-link block">Contact support</a>
                        </div>
                    </div>

                    <div>
                        <p class="footer-title">Marketplace</p>
                        <div class="mt-4 space-y-3">
                            <a href="{{ route('home') }}" class="footer-link block">Browse marketplace</a>
                            <a href="{{ route('home', ['transaction_type' => 'sale']) }}" class="footer-link block">Buy
                                and sell</a>
                            <a href="{{ route('home', ['transaction_type' => 'rent']) }}"
                                class="footer-link block">Rentals</a>
                            <a href="{{ route('home', ['transaction_type' => 'hire']) }}" class="footer-link block">Jobs
                                and hiring</a>
                            <a href="/seller/register" class="footer-link block">Post a listing</a>
                            <a href="/admin" class="footer-link block">Admin access</a>
                        </div>
                    </div>

                    <div>
                        <p class="footer-title">Popular categories</p>
                        <div class="mt-4 space-y-3">
                            <a href="{{ route('home', ['type' => 'vehicle']) }}" class="footer-link block">Vehicles</a>
                            <a href="{{ route('home', ['type' => 'property']) }}" class="footer-link block">Property</a>
                            <a href="{{ route('home', ['type' => 'job']) }}" class="footer-link block">Jobs</a>
                            <a href="{{ route('home', ['type' => 'service']) }}" class="footer-link block">Services</a>
                            <a href="{{ route('home', ['country' => 'Rwanda']) }}" class="footer-link block">Rwanda
                                listings</a>
                            <a href="{{ route('home', ['country' => 'Kenya']) }}" class="footer-link block">Kenya
                                listings</a>
                        </div>
                    </div>

                    <div>
                        <p class="footer-title">Marketplace help</p>
                        <div class="mt-4 space-y-3">
                            <a href="{{ route('home') }}#categories" class="footer-link block">Browse categories</a>
                            <a href="{{ route('home') }}#why-connectify" class="footer-link block">Why connectify?</a>
                            <a href="{{ route('home') }}#featured" class="footer-link block">Featured picks</a>
                            <a href="{{ route('home') }}#latest" class="footer-link block">Fresh listings</a>
                            <a href="https://wa.me/250788881400?text=Hi%2C%20I%20need%20help%20using%20connectify"
                                target="_blank" rel="noreferrer" class="footer-link block">Using the platform</a>
                            <a href="https://wa.me/250788888204?text=Hello%2C%20I%20want%20to%20list%20on%20connectify"
                                target="_blank" rel="noreferrer" class="footer-link block">Listing assistance</a>
                        </div>
                    </div>
                </div>

                <div
                    class="flex flex-col gap-3 pt-6 text-sm text-white/50 md:flex-row md:items-center md:justify-between">
                    <p>&copy; {{ now()->year }} connectify marketplace. All rights reserved.</p>
                    <div class="theme-switch" role="group" aria-label="Color theme">
                        <button type="button" data-theme-choice="system" class="theme-switch__option"
                            aria-label="Use system theme" title="System theme">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                class="h-4 w-4" aria-hidden="true">
                                <rect x="3" y="4" width="18" height="13" rx="2" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 21h8m-4-4v4" />
                            </svg>
                        </button>
                        <button type="button" data-theme-choice="light" class="theme-switch__option"
                            aria-label="Use light theme" title="Light theme">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                class="h-4 w-4" aria-hidden="true">
                                <circle cx="12" cy="12" r="3.5" />
                                <path stroke-linecap="round" d="M12 2v2M12 20v2M4.93 4.93l1.42 1.42M17.65 17.65l1.42 1.42M2 12h2M20 12h2M4.93 19.07l1.42-1.42M17.65 6.35l1.42-1.42" />
                            </svg>
                        </button>
                        <button type="button" data-theme-choice="dark" class="theme-switch__option"
                            aria-label="Use dark theme" title="Dark theme">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                class="h-4 w-4" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.5 14.2A8 8 0 0 1 9.8 3.5 8.5 8.5 0 1 0 20.5 14.2Z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </footer>

        <div
            class="group fixed bottom-[calc(6.75rem+env(safe-area-inset-bottom))] right-4 z-40 md:bottom-6 md:right-6">
            <div
                class="invisible absolute bottom-full right-0 hidden w-72 translate-y-1 pb-3 opacity-0 transition duration-150 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 group-focus-within:visible group-focus-within:translate-y-0 group-focus-within:opacity-100 md:block">
                <div class="overflow-hidden rounded-lg border border-white/10 bg-[#111] text-white shadow-[0_20px_50px_-18px_rgba(0,0,0,0.75)]">
                    <div class="flex items-center justify-between border-b border-white/10 px-4 py-3">
                        <div>
                            <p class="text-sm font-semibold">WhatsApp support</p>
                            <p class="mt-0.5 text-xs text-white/55">Choose a topic to start</p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 text-xs font-medium text-[#58df8b]">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#25d366]"></span>
                            Direct chat
                        </span>
                    </div>
                    @foreach ([
                        ['label' => 'General help', 'description' => 'Questions about using connectify', 'message' => 'Hi, I need help using connectify'],
                        ['label' => 'Cars', 'description' => 'Buying or listing a vehicle', 'message' => 'Hi, I need help with cars on connectify'],
                        ['label' => 'Property', 'description' => 'Buying, renting or listing property', 'message' => 'Hi, I need help with property on connectify'],
                        ['label' => 'Jobs', 'description' => 'Job listings and applications', 'message' => 'Hi, I need help with jobs on connectify'],
                    ] as $option)
                    <a href="https://wa.me/250788881400?text={{ urlencode($option['message']) }}" target="_blank" rel="noreferrer"
                        class="group/option flex items-center gap-3 border-b border-white/8 px-4 py-3 transition last:border-b-0 hover:bg-white/6 focus:bg-white/6 focus:outline-none">
                        <span class="h-2 w-2 shrink-0 rounded-full border border-[#58df8b] transition group-hover/option:bg-[#25d366]"></span>
                        <span class="min-w-0">
                            <span class="block text-sm font-semibold text-white">{{ $option['label'] }}</span>
                            <span class="mt-0.5 block truncate text-xs text-white/55">{{ $option['description'] }}</span>
                        </span>
                    </a>
                    @endforeach
                </div>
            </div>

            <a href="https://wa.me/250788881400?text=Hi%2C%20I%20need%20help%20using%20connectify" target="_blank"
                rel="noreferrer" aria-label="Contact Connectify support on WhatsApp"
                class="flex h-14 w-14 items-center justify-center rounded-full bg-[#25d366] text-white shadow-[0_12px_30px_-12px_rgba(37,211,102,0.8)] transition hover:-translate-y-1 hover:bg-[#20bd5a] focus:outline-none focus:ring-4 focus:ring-emerald-300/40">
                <svg viewBox="0 0 24 24" class="h-7 w-7 fill-current" aria-hidden="true">
                    <path d="M12.04 2a9.84 9.84 0 0 0-8.44 14.9L2 22l5.23-1.55A9.92 9.92 0 1 0 12.04 2Zm5.78 13.95c-.24.68-1.4 1.3-1.94 1.38-.5.08-1.14.12-1.84-.12-.42-.14-.97-.32-1.67-.62-2.94-1.27-4.85-4.23-5-4.43-.14-.2-1.19-1.58-1.19-3.01 0-1.44.75-2.14 1.02-2.44.27-.3.59-.37.79-.37h.57c.18 0 .43-.07.67.51.25.6.85 2.07.92 2.22.08.15.13.32.03.52-.1.2-.15.32-.3.5-.15.17-.31.38-.45.51-.15.15-.3.31-.13.61.17.3.75 1.24 1.61 2 .1.09 1.54 1.35 3.16 1.86.3.1.53.08.73-.12.2-.2.85-.99 1.07-1.33.22-.35.45-.29.75-.18.3.12 1.92.91 2.25 1.07.33.17.55.25.63.39.08.15.08.84-.16 1.55Z" />
                </svg>
            </a>
        </div>

        <nav
            aria-label="Mobile navigation"
            data-mobile-navigation
            class="fixed inset-x-0 bottom-0 z-50 border-t border-white/10 bg-[rgba(7,17,31,0.82)] px-3 pb-[calc(0.75rem+env(safe-area-inset-bottom))] pt-3 backdrop-blur-xl md:hidden">
            <div
                data-mobile-navigation-shell
                class="mx-auto grid max-w-lg grid-cols-5 items-end gap-2 rounded-[2rem] border border-white/10 bg-[linear-gradient(180deg,rgba(255,255,255,0.08),rgba(255,255,255,0.03))] px-2 py-2 shadow-[0_-18px_50px_-26px_rgba(0,0,0,0.7)]">
                <a href="{{ route('home') }}"
                    class="flex flex-col items-center gap-1 rounded-2xl px-2 py-2 text-[11px] font-medium text-white/78 transition hover:bg-white/6 hover:text-white">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5 12 3l9 7.5" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 9.75V21h13.5V9.75" />
                    </svg>
                    <span>Home</span>
                </a>
                <a href="{{ route('home') }}#categories"
                    class="flex flex-col items-center gap-1 rounded-2xl px-2 py-2 text-[11px] font-medium text-white/78 transition hover:bg-white/6 hover:text-white">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5">
                        <circle cx="11" cy="11" r="6" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="m20 20-3.5-3.5" />
                    </svg>
                    <span>Search</span>
                </a>
                <a href="/seller/login" class="-mt-7 flex flex-col items-center gap-1">
                    <span data-mobile-navigation-post
                        class="flex h-14 w-14 items-center justify-center rounded-[1.5rem] bg-[linear-gradient(135deg,var(--color-ocean),#525252)] text-white shadow-[0_22px_45px_-18px_rgba(0,0,0,0.7)] ring-4 ring-black/90 transition hover:-translate-y-0.5">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" class="h-6 w-6">
                            <path stroke-linecap="round" d="M12 5v14M5 12h14" />
                        </svg>
                    </span>
                    <span class="text-[11px] font-semibold uppercase tracking-[0.16em] text-white/82">Post</span>
                </a>
                <a href="https://wa.me/250788881400?text=Hi%2C%20I%20need%20support" target="_blank" rel="noreferrer"
                    class="flex flex-col items-center gap-1 rounded-2xl px-2 py-2 text-[11px] font-medium text-white/78 transition hover:bg-white/6 hover:text-white">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 10.5h10M7 14h6" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20 12c0 4.418-3.582 8-8 8-1.258 0-2.448-.29-3.507-.807L4 20l.807-4.493A7.963 7.963 0 0 1 4 12c0-4.418 3.582-8 8-8s8 3.582 8 8Z" />
                    </svg>
                    <span>Chat</span>
                </a>
                <a href="#mobile-utility"
                    class="flex flex-col items-center gap-1 rounded-2xl px-2 py-2 text-[11px] font-medium text-white/78 transition hover:bg-white/6 hover:text-white">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5">
                        <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                    <span>Menu</span>
                </a>
            </div>
        </nav>
    </div>
</body>

</html>
