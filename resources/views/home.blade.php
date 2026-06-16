<x-layouts.app :title="'connectify | East Africa Marketplace'">
    @php
    $heroListing = $featured->first();
    $heroSideListings = $featured->slice(1);
    @endphp

    <div class="premium-hero-bg pb-12">
        <x-connectify.public-navbar />

        <div id="home-content" data-async-container>
        <main class="pt-32 lg:pt-32">
            <!-- Mobile Landing Page (Block lg:hidden) -->
            <section class="block lg:hidden px-4 pb-4">
                <!-- Mobile Search -->
                <div class="mb-4">
                    <form method="GET" action="{{ route('home') }}" class="relative" data-async-form
                        data-async-target="#home-content" data-async-push-state="true">
                        <input type="text" name="q" placeholder="What are you looking for?"
                            class="w-full rounded-2xl border-none bg-white py-4 pl-12 pr-4 text-sm font-medium text-[var(--color-ink)] shadow-lg ring-1 ring-black/5 focus:ring-2 focus:ring-[var(--color-ocean)]">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </form>
                </div>

                <!-- Category Grid (Dubizzle Style) -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="font-display text-base font-bold text-white">Browse Categories</h2>
                    </div>
                    <div class="grid grid-cols-4 gap-2 mb-2">
                        @foreach ($types as $type)
                        <a href="{{ route('category.show', $type->value) }}"
                            class="flex flex-col items-center gap-1.5 group">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/10 border border-white/10 backdrop-blur-sm transition group-hover:bg-white/20">
                                @php
                                $icon = match($type->value) {
                                'vehicle' => '<svg class="w-8 h-8 text-[var(--color-sand)]" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M8 17a2 2 0 100 4 2 2 0 000-4zM18 17a2 2 0 100 4 2 2 0 000-4z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 11V7a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 5l-1-2H9L8 5M2 13h20" />
                                </svg>',
                                'property' => '<svg class="w-8 h-8 text-[var(--color-sand)]" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>',
                                'job' => '<svg class="w-8 h-8 text-[var(--color-sand)]" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>',
                                'service' => '<svg class="w-8 h-8 text-[var(--color-sand)]" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>',
                                default => '<svg class="w-8 h-8 text-[var(--color-sand)]" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 6h16M4 12h16m-7 6h7" />
                                </svg>'
                                };
                                @endphp
                                {!! $icon !!}
                            </div>
                            <span
                                class="text-[9px] font-bold uppercase tracking-[0.1em] text-white/70 group-hover:text-white">{{
                                $type->label() }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
                <!-- Visual Location Selector (Mobile Only - Dubizzle Style) -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <h2 class="font-display text-base font-bold text-white">
                                @if(empty($filters['country']))
                                Which country would you like to explore?
                                @else
                                Places in {{ $filters['country'] }}
                                @endif
                            </h2>
                        </div>
                        @if(!empty($filters['country']))
                        <a href="{{ route('home', array_merge($filters, ['country' => null, 'city' => null])) }}"
                            data-async-link data-async-target="#home-content" data-async-push-state="true"
                            class="text-[10px] font-bold text-[var(--color-sand)] uppercase tracking-widest hover:opacity-75">Change
                            Country</a>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        @if(empty($filters['country']))
                        @foreach($countries->take(6) as $countryName => $countryLabel)
                        <a href="{{ route('home', array_merge($filters, ['country' => $countryName])) }}"
                            data-async-link data-async-target="#home-content" data-async-push-state="true"
                            class="flex flex-col items-center justify-center rounded-2xl bg-white p-5 text-center shadow-lg ring-1 ring-black/5 transition hover:-translate-y-1 active:scale-95 group dark:border dark:border-white/10 dark:bg-[linear-gradient(180deg,rgba(6,12,22,0.98),rgba(11,20,33,0.96))]">
                            <div
                                class="mb-2 flex h-8 w-8 items-center justify-center rounded-full bg-slate-50 text-slate-400 transition group-hover:bg-[var(--color-ocean)] group-hover:text-white">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <span
                                class="text-[9px] font-bold uppercase tracking-[0.2em] text-slate-400 mb-0.5">Explore</span>
                            <span class="text-sm font-black text-slate-900">{{ $countryLabel }}</span>
                        </a>
                        @endforeach
                        @else
                        @php
                        $citiesToDisplay = $cities->filter(fn($c) => $c !== 'All')->take(8);
                        @endphp
                        @foreach($citiesToDisplay as $cityValue => $cityLabel)
                        <a href="{{ route('home', array_merge($filters, ['city' => $cityValue])) }}"
                            data-async-link data-async-target="#home-content" data-async-push-state="true"
                            class="flex flex-col items-center justify-center rounded-2xl bg-white p-4 text-center shadow-lg ring-1 ring-black/5 transition hover:-translate-y-1 active:scale-95 group dark:border dark:border-white/10 dark:bg-[linear-gradient(180deg,rgba(6,12,22,0.98),rgba(11,20,33,0.96))]">
                            <div
                                class="mb-2 flex h-8 w-8 items-center justify-center rounded-full bg-slate-50 text-slate-400 transition group-hover:bg-[var(--color-ocean)] group-hover:text-white">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <span class="text-[9px] font-bold uppercase tracking-[0.2em] text-slate-400 mb-0.5">{{
                                $filters['country'] }}</span>
                            <span class="text-sm font-black text-slate-900">{{ $cityLabel }}</span>
                        </a>
                        @endforeach
                        @endif
                    </div>
                </div>

                <!-- Featured Horizontal Scroll (Mobile Only) -->
                @if ($featured->isNotEmpty())
                <div class="mb-2">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="font-display text-base font-bold text-white">Featured Deals</h2>
                        <a href="#latest"
                            class="text-[10px] font-bold text-[var(--color-sand)] uppercase tracking-widest">See All</a>
                    </div>
                    <div class="flex gap-4 overflow-x-auto pb-4 hide-scrollbar">
                        @foreach ($featured as $listing)
                        <a href="{{ route('listings.show', $listing) }}"
                            class="min-w-[280px] shrink-0 overflow-hidden rounded-[2rem] bg-white/5 border border-white/10">
                            <div class="relative h-40">
                                <img src="{{ $listing->cover_image }}" class="h-full w-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                                <div class="absolute bottom-3 left-4">
                                    <p class="text-sm font-bold text-white">{{ $listing->formattedPrimaryValue }}</p>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="text-[0.8rem] font-semibold text-white line-clamp-1">{{ $listing->title }}</h3>
                                <p class="mt-1 text-[10px] text-white/60 font-medium uppercase tracking-widest">{{
                                    $listing->city }}, {{ $listing->country }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </section>

            <!-- Desktop Hero Section (Hidden lg:Grid) -->
            <section
                class="hidden lg:grid mx-auto max-w-7xl gap-6 px-4 py-6 sm:px-6 lg:grid-cols-[1.12fr_0.88fr] lg:gap-10 lg:px-8 lg:py-16">
                <div class="hidden lg:block">
                    <span class="gold-chip shadow-[0_18px_40px_-26px_rgba(0,0,0,0.7)]">Cars, homes, jobs and
                        services</span>
                    <h1
                        class="mt-6 max-w-4xl font-display text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-7xl">
                        connectify helps East Africa buy, rent, hire and sell with speed.</h1>
                    <p class="mt-5 max-w-2xl text-base leading-7 text-white/72 sm:text-lg">From vehicles and homes to
                        jobs
                        and everyday services, connectify brings trusted local listings, location-first discovery and
                        direct
                        WhatsApp conversations into one modern regional marketplace.</p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="#latest" class="primary-cta">Browse listings</a>
                        <a href="/seller/login" class="secondary-cta">Start selling</a>
                    </div>

                    <div class="mt-8 grid gap-4 sm:grid-cols-3">
                        <div class="dark-stat">
                            <p class="text-3xl font-extrabold text-white">{{ number_format($stats['liveListings']) }} listings</p>
                            <p class="mt-2 text-sm italic text-white/65">Live listings across cars, jobs, property and
                                services.
                            </p>
                        </div>
                        <div class="dark-stat">
                            <p class="text-3xl font-extrabold text-white">{{ number_format($stats['verifiedSellers']) }} verified seller{{ $stats['verifiedSellers'] === 1 ? '' : 's' }}</p>
                            <p class="mt-2 text-sm italic text-white/65">Verified sellers ready to close on WhatsApp.</p>
                        </div>
                        <div class="dark-stat">
                            <p class="text-3xl font-extrabold text-white">{{ number_format($stats['countries']) }} markets</p>
                            <p class="mt-2 text-sm italic text-white/65">East African markets covered from launch.</p>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-wrap gap-3 text-sm text-white/70">
                        <span class="rounded-full border border-white/10 px-4 py-2">Kigali</span>
                        <span class="rounded-full border border-white/10 px-4 py-2">Nairobi</span>
                        <span class="rounded-full border border-white/10 px-4 py-2">Kampala</span>
                        <span class="rounded-full border border-white/10 px-4 py-2">Dar es Salaam</span>
                        <span class="rounded-full border border-white/10 px-4 py-2">Bujumbura</span>
                    </div>
                </div>

                <div class="space-y-4 lg:space-y-5">
                    <!-- Mobile View Hero Title (Moved here or kept for context) -->
                    <div class="lg:hidden">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-[var(--color-sand)]">
                            Marketplace</p>
                        <h1 class="mt-2 font-display text-3xl font-bold tracking-tight text-white">Find, post, chat,
                            move.
                        </h1>
                        <p class="mt-2 text-sm leading-6 text-white/62">Search first, browse fast, and act without
                            getting
                            lost in extra content.</p>
                    </div>

                    <form method="GET" action="{{ route('home') }}"
                        class="hero-panel space-y-5 rounded-[2rem] p-5 text-white md:p-6" data-country-city-filter
                        data-country-city-map='@json($countryCityMap)' data-async-form data-async-target="#home-content"
                        data-async-push-state="true">
                        <div class="border-b border-white/8 pb-4">
                            <p class="section-heading">Explore connectify</p>
                            <h2 class="mt-2 font-display text-2xl font-bold text-white">Find your next move</h2>
                            <p class="mt-2 text-sm text-white/60">Premium browsing, verified sellers, faster WhatsApp
                                conversations.</p>
                        </div>

                        <div class="mb-4">
                            <label class="space-y-2">
                                <span
                                    class="block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/58">Keyword
                                    Search</span>
                                <input type="text" name="q" value="{{ $filters['q'] ?? '' }}"
                                    placeholder="Search cars, homes, jobs..."
                                    class="connectify-input">
                            </label>
                        </div>

                        <div class="mb-4 grid gap-3 sm:grid-cols-2">
                            <label class="space-y-2">
                                <span
                                    class="block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/58">Min
                                    Price</span>
                                <input type="number" name="min_price" value="{{ $filters['min_price'] ?? '' }}"
                                    placeholder="0" class="connectify-input">
                            </label>
                            <label class="space-y-2">
                                <span
                                    class="block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/58">Max
                                    Price</span>
                                <input type="number" name="max_price" value="{{ $filters['max_price'] ?? '' }}"
                                    placeholder="Any" class="connectify-input">
                            </label>
                        </div>

                        <div class="grid gap-3 sm:grid-cols-2">
                            <label class="space-y-2">
                                <span
                                    class="block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/58">Country</span>
                                <select name="country" class="connectify-input text-slate-800" data-country-select>
                                    <option value="">All countries</option>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country }}" {{ ($filters['country'] ?? '' )===$country
                                        ? 'selected' : '' }}>{{ $country }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="space-y-2 sm:col-span-2">
                                <span
                                    class="block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/58">City</span>
                                <select name="city" class="connectify-input text-slate-800" data-city-select
                                    @disabled(blank($filters['country'] ?? '' ))>
                                    <option value="">{{ ($filters['country'] ?? '') ? 'All cities' : 'Choose country
                                        first' }}</option>
                                    @foreach ($cities as $city)
                                    <option value="{{ $city }}" {{ ($filters['city'] ?? '' )===$city ? 'selected' : ''
                                        }}>{{ $city }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="space-y-2 sm:col-span-2">
                                <span
                                    class="block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/58">Category</span>
                                <select name="type" class="connectify-input text-slate-800">
                                    <option value="">All categories</option>
                                    @foreach ($types as $type)
                                    <option value="{{ $type->value }}" {{ ($filters['type'] ?? '' )===$type->value ?
                                        'selected' : '' }}>{{ $type->label() }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>

                        <div>
                            <p class="mb-3 text-xs font-semibold uppercase tracking-[0.22em] text-white/55">Choose
                                intent
                            </p>
                            <div class="grid grid-cols-1 gap-3 text-sm sm:grid-cols-3 sm:text-center">
                                <label class="cursor-pointer">
                                    <input type="radio" name="transaction_type" value="rent" class="peer sr-only" {{
                                        ($filters['transaction_type'] ?? '' )==='rent' ? 'checked' : '' }}>
                                    <span
                                        class="block rounded-2xl border border-white/8 bg-white/5 px-4 py-4 transition peer-checked:border-[rgba(29,143,255,0.45)] peer-checked:bg-[rgba(29,143,255,0.14)] peer-checked:shadow-[0_18px_40px_-24px_rgba(29,143,255,0.7)] sm:px-3">
                                        <span class="font-bold text-white">Rent</span>
                                        <span class="mt-1 block text-xs text-white/55">Homes and cars</span>
                                    </span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="transaction_type" value="sale" class="peer sr-only" {{
                                        ($filters['transaction_type'] ?? '' )==='sale' ? 'checked' : '' }}>
                                    <span
                                        class="block rounded-2xl border border-white/8 bg-white/5 px-4 py-4 transition peer-checked:border-[rgba(29,143,255,0.45)] peer-checked:bg-[rgba(29,143,255,0.14)] peer-checked:shadow-[0_18px_40px_-24px_rgba(29,143,255,0.7)] sm:px-3">
                                        <span class="font-bold text-white">Buy</span>
                                        <span class="mt-1 block text-xs text-white/55">Vehicles and property</span>
                                    </span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="transaction_type" value="hire" class="peer sr-only" {{
                                        ($filters['transaction_type'] ?? '' )==='hire' ? 'checked' : '' }}>
                                    <span
                                        class="block rounded-2xl border border-white/8 bg-white/5 px-4 py-4 transition peer-checked:border-[rgba(29,143,255,0.45)] peer-checked:bg-[rgba(29,143,255,0.14)] peer-checked:shadow-[0_18px_40px_-24px_rgba(29,143,255,0.7)] sm:px-3">
                                        <span class="font-bold text-white">Hire</span>
                                        <span class="mt-1 block text-xs text-white/55">Jobs and talent</span>
                                    </span>
                                </label>
                            </div>
                            @if ($filters['transaction_type'] ?? '')
                            <div class="mt-3">
                                <a href="{{ route('home', collect($filters ?? [])->except('transaction_type')->filter()->all()) }}"
                                    data-async-link data-async-target="#home-content" data-async-push-state="true"
                                    class="text-xs font-semibold uppercase tracking-[0.18em] text-white/60 transition hover:text-white">Clear
                                    intent</a>
                            </div>
                            @endif
                        </div>

                        <button type="submit" class="primary-cta w-full">Search marketplace</button>
                    </form>

            </section>

            @if ($heroListing)
            <a href="{{ route('listings.show', $heroListing) }}"
                class="featured-image-card hero-panel mx-auto hidden w-full max-w-5xl overflow-hidden rounded-[2rem] p-4 transition hover:-translate-y-1 md:p-5 lg:block">
                <div class="relative aspect-[16/8] overflow-hidden rounded-[1.5rem]">
                    <img src="{{ $heroListing->cover_image }}" alt="{{ $heroListing->title }}"
                        class="absolute inset-0 h-full w-full object-cover object-center">
                    <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(9,11,15,0.08),rgba(9,11,15,0.82))]">
                    </div>
                    <div class="absolute inset-x-0 bottom-0 p-5">
                        <span class="gold-chip">Featured</span>
                        <h3 class="mt-3 font-display text-xl font-bold text-white">{{ $heroListing->title }}
                        </h3>
                        <div class="mt-3 flex items-end justify-between gap-4">
                            <div>
                                <p class="text-xl font-extrabold text-white">{{
                                    $heroListing->formattedPrimaryValue }}</p>
                                <p class="text-sm text-white/65">{{ $heroListing->city }}, {{
                                    $heroListing->country
                                    }}</p>
                            </div>
                            <span
                                class="rounded-full border border-white/12 bg-white/10 px-4 py-2 text-sm font-semibold text-white">View
                                deal</span>
                        </div>
                    </div>
                </div>
            </a>
            @endif
    </div>
    </section>
    </main>

    <section id="categories" class="mx-auto hidden lg:block max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-5 flex items-end justify-between gap-4">
            <div>
                <p class="section-heading">Core verticals</p>
                <h2 class="mt-2 font-display text-2xl font-bold text-[var(--color-ink)] sm:text-3xl">Browse the
                    marketplace like a product, not a noticeboard</h2>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
            @foreach ($types as $type)
            <a href="{{ route('category.show', $type->value) }}"
                class="surface-card group rounded-[1.5rem] p-4 text-[var(--color-ink)] shadow-[0_20px_50px_-30px_rgba(8,20,33,0.35)] transition hover:-translate-y-1 hover:border-[var(--color-ocean)] sm:rounded-[1.75rem] sm:p-6 dark:border-white/10 dark:bg-[linear-gradient(180deg,rgba(6,12,22,0.98),rgba(11,20,33,0.96))] dark:text-[#eaf2ff]">
                <p class="section-heading dark:text-slate-400">{{ $type->value }}</p>
                <h3 class="mt-3 font-display text-xl font-bold sm:text-2xl dark:text-[#eaf2ff]">{{ $type->label() }}</h3>
                <p class="mt-3 hidden text-sm leading-6 text-slate-600 dark:text-slate-300 sm:block">{{ match($type->value) {
                    'vehicle' => 'Sell and discover cars ready for city roads and cross-border travel.',
                    'property' => 'Browse homes, rentals and commercial spaces in prime neighborhoods.',
                    'job' => 'Reach serious employers and job seekers across the region.',
                    default => 'List trusted services, rentals and specialist business offerings.',
                    } }}</p>
                <div class="mt-4 flex items-center justify-between sm:mt-6">
                    <span class="inline-flex text-sm font-semibold text-[var(--color-ocean)] dark:text-[#7eb7ff]">Browse now</span>
                    <span class="text-lg text-[var(--color-clay)] dark:text-slate-400">{{ number_format($categoryCounts[$type->value] ?? 0) }}</span>
                </div>
            </a>
            @endforeach
        </div>
    </section>

    <section id="why-connectify" class="mx-auto hidden max-w-7xl px-4 py-10 sm:px-6 lg:block lg:px-8">
        <div class="hero-panel rounded-[2rem] px-6 py-8 md:px-8 dark:bg-[linear-gradient(180deg,rgba(6,12,22,0.98),rgba(11,20,33,0.96))]">
            <div class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
                <div>
                    <p class="gold-chip">Why connectify?</p>
                    <h2 class="mt-4 max-w-xl font-display text-3xl font-bold text-white md:text-4xl">One marketplace
                        for trusted cars, homes, jobs and business services across East Africa.</h2>
                    <p class="mt-4 max-w-lg text-sm leading-7 text-white/72">connectify helps buyers and renters
                        move faster with verified listings, clear location filters, direct WhatsApp contact, and a
                        regional inventory that starts in Rwanda and extends into Uganda, Burundi, DRC, Kenya,
                        Tanzania, and South Sudan.</p>
                </div>
                <div class="grid gap-4 md:grid-cols-3">
                    <div class="rounded-[1.5rem] border border-white/8 bg-white/6 p-5 dark:border-white/10 dark:bg-[linear-gradient(180deg,rgba(6,12,22,0.98),rgba(11,20,33,0.96))]">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[var(--color-sand)]">01</p>
                        <h3 class="mt-4 font-display text-xl font-bold text-white">Verified sellers</h3>
                        <p class="mt-3 text-sm leading-6 text-white/72">Every featured seller profile can include
                            business identity, WhatsApp details, and listing history so buyers know who they are
                            dealing with before they enquire.</p>
                    </div>
                    <div class="rounded-[1.5rem] border border-white/8 bg-white/6 p-5 dark:border-white/10 dark:bg-[linear-gradient(180deg,rgba(6,12,22,0.98),rgba(11,20,33,0.96))]">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[var(--color-sand)]">02</p>
                        <h3 class="mt-4 font-display text-xl font-bold text-white">Location-first discovery</h3>
                        <p class="mt-3 text-sm leading-6 text-white/72">Choose a country first, then filter by real
                            cities to see inventory that actually matches where you want to buy, rent, hire or
                            relocate.</p>
                    </div>
                    <div class="rounded-[1.5rem] border border-white/8 bg-white/6 p-5 dark:border-white/10 dark:bg-[linear-gradient(180deg,rgba(6,12,22,0.98),rgba(11,20,33,0.96))]">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[var(--color-sand)]">03</p>
                        <h3 class="mt-4 font-display text-xl font-bold text-white">WhatsApp conversion</h3>
                        <p class="mt-3 text-sm leading-6 text-white/72">Instead of losing buyers in long forms,
                            connectify pushes serious enquiries straight into WhatsApp for viewings, negotiations,
                            tenancy questions and hiring follow-up.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="featured" class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between gap-4">
            <div>
                <p class="section-heading">Featured listings</p>
                <h2 class="mt-2 font-display text-3xl font-bold text-[var(--color-ink)] dark:text-[#eaf2ff]">High-intent listings worth
                    viewing first</h2>
            </div>
            <a href="/admin"
                class="hidden rounded-full border border-[var(--color-sand)] bg-white/70 px-4 py-2 text-sm font-semibold text-[var(--color-ink)] shadow-[0_18px_32px_-22px_rgba(8,20,33,0.4)] md:inline-flex">Admin
                Panel</a>
        </div>

        <div class="mt-6 grid gap-5 lg:grid-cols-[1.15fr_0.85fr]">
            @if ($heroListing)
            <article
                class="featured-image-card group self-start rounded-[2rem] bg-[var(--color-ink)] p-3 text-white shadow-[0_30px_80px_-38px_rgba(0,0,0,0.7)] md:p-4">
                <div class="relative mx-auto aspect-[16/9] max-w-[58rem] overflow-hidden rounded-[1.5rem]">
                    <img src="{{ $heroListing->cover_image }}" alt="{{ $heroListing->title }}"
                        class="absolute inset-0 h-full w-full object-cover object-center">
                    @auth
                    @php $isSaved = auth()->user()->savedListings->contains($heroListing->id); @endphp
                    <form method="POST" action="{{ route($isSaved ? 'saved.destroy' : 'saved.store', $heroListing) }}"
                        class="absolute top-6 right-6 z-20 hidden group-hover:block">
                        @csrf
                        @if ($isSaved) @method('DELETE') @endif
                        <button type="submit"
                            class="rounded-full bg-white/90 p-3 shadow-lg backdrop-blur transition hover:scale-105"
                            title="{{ $isSaved ? 'Unsave' : 'Save' }}">
                            <svg class="h-6 w-6 {{ $isSaved ? 'fill-red-500 text-red-500' : 'fill-none text-slate-800' }}"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                        </button>
                    </form>
                    @endauth
                    <div
                        class="absolute inset-0 bg-[linear-gradient(90deg,rgba(9,11,15,0.92),rgba(9,11,15,0.38),rgba(9,11,15,0.72))]">
                    </div>
                    <div class="absolute inset-0 flex flex-col justify-between p-7 md:p-9">
                        <div class="flex items-start justify-between gap-4">
                            <span class="gold-chip">Featured listing</span>
                            @if ($heroListing->is_verified)
                            <span
                                class="rounded-full border border-white/12 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-white">Verified
                                seller</span>
                            @endif
                        </div>
                        <div class="max-w-xl">
                            <p class="text-sm uppercase tracking-[0.24em] text-[var(--color-sand)]">{{
                                $heroListing->type->label() }}</p>
                            <h3 class="mt-3 font-display text-3xl font-bold text-white md:text-5xl">{{ $heroListing->title }}</h3>
                            <p class="mt-4 max-w-lg text-sm leading-7 text-white/75">{{
                                \Illuminate\Support\Str::limit($heroListing->description, 180) }}</p>
                            <div class="mt-6 flex flex-wrap items-end gap-4">
                                <div>
                                    <p class="text-3xl font-extrabold text-white">{{
                                        $heroListing->formattedPrimaryValue }}</p>
                                    <p class="mt-1 text-sm text-white/75">{{ $heroListing->city }}, {{
                                        $heroListing->country }}</p>
                                </div>
                                <a href="{{ route('listings.show', $heroListing) }}" class="primary-cta">Open
                                    listing</a>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
            @endif

            <div class="grid gap-5">
                @foreach ($heroSideListings as $listing)
                <article class="surface-card overflow-hidden rounded-[2rem] text-[var(--color-ink)] relative group dark:border-white/10 dark:bg-[linear-gradient(180deg,rgba(6,12,22,0.98),rgba(11,20,33,0.96))] dark:text-[#eaf2ff]">
                    @auth
                    @php $isSaved = auth()->user()->savedListings->contains($listing->id); @endphp
                    <form method="POST" action="{{ route($isSaved ? 'saved.destroy' : 'saved.store', $listing) }}"
                        class="absolute top-4 right-4 z-20 hidden md:group-hover:block">
                        @csrf
                        @if ($isSaved) @method('DELETE') @endif
                        <button type="submit"
                            class="rounded-full bg-white/90 p-2 shadow backdrop-blur transition hover:scale-105 dark:bg-[linear-gradient(180deg,rgba(6,12,22,0.98),rgba(11,20,33,0.96))]"
                            title="{{ $isSaved ? 'Unsave' : 'Save' }}">
                            <svg class="h-5 w-5 {{ $isSaved ? 'fill-red-500 text-red-500' : 'fill-none text-slate-800 dark:text-[#eaf2ff]' }}"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                        </button>
                    </form>
                    @endauth
                    <div class="grid gap-0 md:grid-cols-[0.42fr_0.58fr]">
                        <img src="{{ $listing->cover_image }}" alt="{{ $listing->title }}"
                            class="h-full min-h-52 w-full object-cover">
                        <div class="p-6">
                            <div class="flex items-center justify-between gap-4">
                                <span
                                    class="rounded-full bg-[var(--color-mist)] px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-[var(--color-clay)] dark:bg-[linear-gradient(180deg,rgba(6,12,22,0.98),rgba(11,20,33,0.96))] dark:text-[var(--color-sand)]">{{
                                    $listing->type->label() }}</span>
                                <span class="text-xs uppercase tracking-[0.18em] text-slate-500 dark:text-slate-400">{{
                                    ucfirst($listing->transaction_type) }}</span>
                            </div>
                            <h3 class="mt-4 font-display text-xl font-bold text-[var(--color-ink)] dark:text-[#eaf2ff]"><a
                                    href="{{ route('listings.show', $listing) }}">{{ $listing->title }}</a></h3>
                            <p class="mt-3 text-sm leading-6 text-slate-600 dark:text-slate-300">{{
                                \Illuminate\Support\Str::limit($listing->description, 110) }}</p>
                            <div class="mt-5 flex items-end justify-between gap-4">
                                <div>
                                    <p class="text-xl font-extrabold text-[var(--color-ink)] dark:text-[#eaf2ff]">{{ $listing->formattedPrimaryValue }}</p>
                                    <p class="text-sm text-slate-500 dark:text-slate-300">{{ $listing->city }}, {{ $listing->country }}
                                    </p>
                                </div>
                                <a href="{{ $listing->whatsappUrl }}" target="_blank"
                                    class="inline-flex items-center justify-center rounded-full bg-[linear-gradient(135deg,var(--color-leaf),#31b98b)] px-4 py-2 text-sm font-semibold text-white shadow-[0_18px_40px_-20px_rgba(22,149,107,0.8)] dark:shadow-[0_18px_40px_-20px_rgba(0,0,0,0.9)]">WhatsApp</a>
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="latest" class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8" data-async-container>
        <div class="surface-card rounded-[2rem] p-6 text-[var(--color-ink)] md:p-8 dark:border-white/10 dark:bg-[linear-gradient(180deg,rgba(6,12,22,0.98),rgba(11,20,33,0.96))] dark:text-[#eaf2ff]">
            <div class="flex flex-col gap-3 border-b border-slate-200 pb-6 md:flex-row md:items-end md:justify-between dark:border-white/10">
                <div>
                    <p class="section-heading">Latest listings</p>
                    <h2 class="mt-2 font-display text-3xl font-bold text-[var(--color-ink)] dark:text-[#eaf2ff]">Fresh from the marketplace</h2>
                </div>
                <p class="max-w-xl text-sm leading-6 text-slate-600 dark:text-slate-300">New stock, rentals, job posts and service
                    offers appear here first, giving buyers and applicants a current view of what is available in
                    their selected country and city.</p>
            </div>

            <div class="mt-6 grid gap-4 lg:grid-cols-3">
                @forelse ($listings as $listing)
                <article
                    class="surface-card-soft rounded-[1.5rem] p-4 transition hover:-translate-y-1 hover:border-[var(--color-ocean)] hover:shadow-lg relative group dark:border-white/10 dark:bg-[linear-gradient(180deg,rgba(6,12,22,0.98),rgba(11,20,33,0.96))] dark:text-[#eaf2ff]">
                    @auth
                    @php $isSaved = auth()->user()->savedListings->contains($listing->id); @endphp
                    <form method="POST" action="{{ route($isSaved ? 'saved.destroy' : 'saved.store', $listing) }}"
                        class="absolute top-6 right-6 z-20 hidden md:group-hover:block">
                        @csrf
                        @if ($isSaved) @method('DELETE') @endif
                        <button type="submit"
                            class="rounded-full bg-white/90 p-2 shadow backdrop-blur transition hover:scale-105"
                            title="{{ $isSaved ? 'Unsave' : 'Save' }}">
                            <svg class="h-5 w-5 {{ $isSaved ? 'fill-red-500 text-red-500' : 'fill-none text-slate-800' }}"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                        </button>
                    </form>
                    @endauth
                    <img src="{{ $listing->cover_image }}" alt="{{ $listing->title }}"
                        class="h-48 w-full rounded-[1.25rem] object-cover">
                    <div class="mt-4 flex items-center justify-between gap-3">
                        <span
                            class="rounded-full bg-[var(--color-mist)] px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-[var(--color-clay)] dark:text-[var(--color-clay)]">{{
                            $listing->type->label() }}</span>
                        <span class="text-xs text-slate-500 dark:text-slate-300">{{ $listing->area ?? $listing->city }}</span>
                    </div>
                    <h3 class="mt-3 font-display text-xl font-bold text-[var(--color-ink)] dark:text-[#eaf2ff]"><a href="{{ route('listings.show', $listing) }}">{{
                            $listing->title }}</a></h3>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">{{ $listing->city }}, {{ $listing->country }}</p>
                    <p class="mt-3 text-sm leading-6 text-slate-600 dark:text-slate-300">{{
                        \Illuminate\Support\Str::limit($listing->description, 100) }}</p>
                    <div class="mt-4 flex items-center justify-between gap-3">
                        <div>
                            <p class="text-lg font-extrabold text-[var(--color-ink)] dark:text-[#eaf2ff]">{{ $listing->formattedPrimaryValue }}</p>
                            <p class="text-xs uppercase tracking-[0.18em] text-slate-500 dark:text-slate-300">{{
                                $listing->seller?->company_name ?? $listing->seller?->name }}</p>
                        </div>
                        <a href="{{ route('listings.show', $listing) }}"
                            class="rounded-full border border-[var(--color-sand)] bg-white/70 px-4 py-2 text-sm font-semibold shadow-[0_12px_24px_-18px_rgba(8,20,33,0.4)] dark:border-white/10 dark:bg-[linear-gradient(180deg,rgba(6,12,22,0.98),rgba(11,20,33,0.96))] dark:text-[#eaf2ff]">View</a>
                    </div>
                </article>
                @empty
                <div class="lg:col-span-3">
                <div class="surface-card-soft rounded-[1.5rem] border-dashed px-6 py-12 text-center dark:border-white/10 dark:bg-[linear-gradient(180deg,rgba(6,12,22,0.98),rgba(11,20,33,0.96))]">
                        <h3 class="font-display text-xl font-bold text-[var(--color-ink)] dark:text-[#eaf2ff]">No listings match your filters</h3>
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Try a different country or city, broaden your
                            category, or publish a new listing from the seller panel to start building local
                            inventory.</p>
                    </div>
                </div>
                @endforelse
            </div>

            <div class="mt-6">{{ $listings->links() }}</div>
        </div>
    </section>
    </main>
    </div>
</x-layouts.app>
