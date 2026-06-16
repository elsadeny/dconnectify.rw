<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'connectify Marketplace' }}</title>
    <meta name="description"
        content="connectify is a modern East African marketplace for cars, jobs, rentals, services and real estate.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,700|plus-jakarta-sans:400,500,600,700,800"
        rel="stylesheet" />
    <script>
        (() => {
            const storageKey = 'connectify-theme';
            const theme = localStorage.getItem(storageKey) || 'auto';
            const hour = new Date().getHours();
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            const isNight = hour >= 18 || hour < 7;
            const resolvedTheme = theme === 'light' ? 'light' : theme === 'dark' ? 'dark' : theme === 'system' ? (prefersDark ? 'dark' : 'light') : (isNight ? 'dark' : 'light');

            document.documentElement.dataset.theme = theme;
            document.documentElement.classList.toggle('dark', resolvedTheme === 'dark');
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
            --color-ink: #07111f;
            --color-night: #0d1b2e;
            --color-deep: #16314f;
            --color-paper: #edf4fb;
            --color-paper-strong: #f8fbff;
            --color-sun: #67b8ff;
            --color-clay: #2f6ea8;
            --color-ocean: #1d8fff;
            --color-leaf: #16956b;
            --color-mist: #dfeefa;
            --color-sand: #9fcbf5;
            --color-steel: #6f8da9;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--color-paper);
        }

        .premium-hero-bg {
            background:
                radial-gradient(circle at 14% 10%, rgba(29, 143, 255, 0.26), transparent 24%),
                radial-gradient(circle at 85% 12%, rgba(103, 184, 255, 0.14), transparent 18%),
                linear-gradient(180deg, #040914 0%, var(--color-night) 60%, var(--color-deep) 100%);
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
                linear-gradient(135deg, rgba(29, 143, 255, 0.1), transparent 30%);
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
            border: 1px solid #cfe0f0;
            box-shadow: 0 28px 80px -42px rgba(8, 20, 33, 0.45);
        }

        .surface-card-soft {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.95), rgba(232, 242, 252, 0.95));
            border: 1px solid #d7e6f5;
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
            background: linear-gradient(135deg, var(--color-ocean), #8fd0ff);
            box-shadow: 0 18px 40px -18px rgba(29, 143, 255, 0.72);
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
            border: 1px solid rgba(29, 143, 255, 0.28);
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.18em;
            color: var(--color-clay);
            background: linear-gradient(180deg, rgba(29, 143, 255, 0.18), rgba(29, 143, 255, 0.08));
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
            border: 1px solid #d6e6f6;
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
    <div class="page-orb left-[-8rem] top-16 h-64 w-64 bg-[rgba(29,143,255,0.22)]"></div>
    <div class="page-orb right-[-7rem] top-28 h-72 w-72 bg-[rgba(103,184,255,0.14)]"></div>
    <div class="page-orb bottom-20 left-[20%] h-60 w-60 bg-[rgba(56,118,184,0.18)]"></div>
    <div class="site-shell">
        {{ $slot }}

        <footer id="site-footer"
            class="mt-12 hidden border-t border-white/8 bg-[linear-gradient(180deg,rgba(7,17,31,0.96),rgba(4,9,20,1))] md:block">
            <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
                <div
                    class="mb-8 grid gap-4 rounded-[2rem] border border-white/8 bg-white/5 p-5 md:grid-cols-[1.25fr_0.75fr_0.75fr] md:items-center md:p-6">
                    <div>
                        <p class="footer-title">Support channels</p>
                        <h2 class="mt-3 font-display text-2xl font-bold text-white">Support buyers, renters, job seekers
                            and sellers from one marketplace.</h2>
                        <p class="mt-2 max-w-xl text-sm leading-6 text-white/62">Keep trusted support and onboarding
                            channels visible so people can move from browsing to conversation fast across every
                            category.</p>
                    </div>
                    <a href="https://wa.me/250788888209?text=Hi%2C%20I%20need%20support" target="_blank"
                        rel="noreferrer"
                        class="rounded-[1.5rem] border border-white/10 bg-white/6 px-5 py-4 transition hover:-translate-y-0.5 hover:bg-white/8">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[var(--color-sand)]">
                            Marketplace support</p>
                        <p class="mt-2 text-lg font-bold text-white">Chat on WhatsApp</p>
                        <p class="mt-1 text-sm text-white/58">+250 788 888 209</p>
                    </a>
                    <a href="https://wa.me/250788888204?text=Hello%2C%20I%27m%20interested" target="_blank"
                        rel="noreferrer"
                        class="rounded-[1.5rem] border border-white/10 bg-white/6 px-5 py-4 transition hover:-translate-y-0.5 hover:bg-white/8">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[var(--color-sand)]">Seller
                            onboarding</p>
                        <p class="mt-2 text-lg font-bold text-white">List with connectify</p>
                        <p class="mt-1 text-sm text-white/58">+250 788 888 204</p>
                    </a>
                </div>

                <div class="grid gap-8 border-b border-white/8 pb-8 lg:grid-cols-[1.2fr_0.8fr_0.8fr_0.8fr_0.8fr]">
                    <div>
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-full bg-[linear-gradient(135deg,var(--color-ocean),#8fd0ff)] text-lg font-black text-[var(--color-ink)] shadow-[0_14px_35px_-16px_rgba(29,143,255,0.8)]">
                                C</div>
                            <div>
                                <p class="font-display text-xl font-bold text-white">connectify</p>
                                <p class="text-xs uppercase tracking-[0.24em] text-white/50">East Africa marketplace</p>
                            </div>
                        </div>
                        <p class="mt-5 max-w-sm text-sm leading-7 text-white/60">connectify is a modern East African
                            marketplace for vehicles, property, jobs, rentals and services, helping people discover
                            trusted listings and connect with sellers faster.</p>
                        <div class="mt-5 flex flex-wrap gap-3 text-sm">
                            <a href="https://wa.me/250788888209" target="_blank" rel="noreferrer"
                                class="footer-link">WhatsApp</a>
                            <a href="https://www.facebook.com/haruna.nyamushanja/" target="_blank" rel="noreferrer"
                                class="footer-link">Facebook</a>
                            <a href="https://www.instagram.com/connectify.rw/" target="_blank" rel="noreferrer"
                                class="footer-link">Instagram</a>
                            <a href="https://x.com/CarconnectRw" target="_blank" rel="noreferrer"
                                class="footer-link">X</a>
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
                            <a href="https://wa.me/250788888209?text=Hi%2C%20I%20need%20support" target="_blank"
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
                            <a href="https://wa.me/250788888209?text=Hi%2C%20I%20need%20help%20using%20connectify"
                                target="_blank" rel="noreferrer" class="footer-link block">Using the platform</a>
                            <a href="https://wa.me/250788888204?text=Hello%2C%20I%20want%20to%20list%20on%20connectify"
                                target="_blank" rel="noreferrer" class="footer-link block">Listing assistance</a>
                        </div>
                    </div>
                </div>

                <div
                    class="flex flex-col gap-3 pt-6 text-sm text-white/50 md:flex-row md:items-center md:justify-between">
                    <p>&copy; {{ now()->year }} connectify marketplace. All rights reserved.</p>
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="/seller" class="footer-link">Seller Sign In</a>
                        <a href="/seller/register" class="footer-link">Seller Sign Up</a>
                        <a href="https://www.instagram.com/connectify.rw/" target="_blank" rel="noreferrer"
                            class="footer-link">Instagram</a>
                        <a href="https://wa.me/250788888209?text=Hi%2C%20I%20need%20support" target="_blank"
                            rel="noreferrer" class="footer-link">Contact</a>
                        <div class="flex flex-wrap items-center gap-2">
                            <button type="button" data-theme-choice="auto"
                                class="theme-pill">Auto</button>
                            <button type="button" data-theme-choice="system"
                                class="theme-pill">System</button>
                            <button type="button" data-theme-choice="light"
                                class="theme-pill">Light</button>
                            <button type="button" data-theme-choice="dark"
                                class="theme-pill">Dark</button>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <nav
            class="fixed inset-x-0 bottom-0 z-50 border-t border-white/10 bg-[rgba(7,17,31,0.82)] px-3 pb-[calc(0.75rem+env(safe-area-inset-bottom))] pt-3 backdrop-blur-xl md:hidden">
            <div
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
                    <span
                        class="flex h-14 w-14 items-center justify-center rounded-[1.5rem] bg-[linear-gradient(135deg,var(--color-ocean),#8fd0ff)] text-[var(--color-ink)] shadow-[0_22px_45px_-18px_rgba(29,143,255,0.8)] ring-4 ring-[rgba(7,17,31,0.88)] transition hover:-translate-y-0.5">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" class="h-6 w-6">
                            <path stroke-linecap="round" d="M12 5v14M5 12h14" />
                        </svg>
                    </span>
                    <span class="text-[11px] font-semibold uppercase tracking-[0.16em] text-white/82">Post</span>
                </a>
                <a href="https://wa.me/250788888209?text=Hi%2C%20I%20need%20support" target="_blank" rel="noreferrer"
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
