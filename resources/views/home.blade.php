<x-layouts.app :title="'Connectify | East Africa Marketplace'">
    @php
        $heroListing = $featured->first();
        $heroSideListings = $featured->slice(1);
    @endphp

    <header class="fixed inset-x-0 top-0 z-50 px-4 pt-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="glass-panel flex items-center justify-between rounded-full px-4 py-3 md:px-6">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-full bg-[linear-gradient(135deg,var(--color-ocean),#8fd0ff)] text-lg font-black text-[var(--color-ink)]">C</div>
                <div>
                    <p class="font-display text-lg font-bold tracking-tight">Connectify</p>
                    <p class="text-xs uppercase tracking-[0.24em] text-white/60">Premium marketplace across East Africa</p>
                </div>
            </a>
            <nav class="hidden items-center gap-6 text-sm font-medium text-white/80 md:flex">
                <a href="#categories" class="transition hover:text-white">Categories</a>
                <a href="#why-connectify" class="transition hover:text-white">Why Connectify</a>
                <a href="#featured" class="transition hover:text-white">Featured</a>
                <a href="#latest" class="transition hover:text-white">Latest</a>
                <a href="/seller" class="rounded-full border border-white/15 bg-white/95 px-4 py-2 text-[var(--color-ink)] transition hover:-translate-y-0.5">Seller Panel</a>
            </nav>
        </div>
        </div>
    </header>

    <main class="pt-28 lg:pt-32">

        <section class="mx-auto grid max-w-7xl gap-6 px-4 py-6 sm:px-6 lg:grid-cols-[1.12fr_0.88fr] lg:gap-10 lg:px-8 lg:py-16">
            <div class="hidden lg:block">
                <span class="gold-chip shadow-[0_18px_40px_-26px_rgba(0,0,0,0.7)]">Cars, homes, jobs and services</span>
                <h1 class="mt-6 max-w-4xl font-display text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-7xl">Connectify helps East Africa buy, rent, hire and sell with speed.</h1>
                <p class="mt-5 max-w-2xl text-base leading-7 text-white/72 sm:text-lg">From vehicles and homes to jobs and everyday services, Connectify brings trusted local listings, location-first discovery and direct WhatsApp conversations into one modern regional marketplace.</p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#latest" class="primary-cta">Browse listings</a>
                    <a href="/seller/register" class="secondary-cta">Start selling</a>
                </div>

                <div class="mt-8 grid gap-4 sm:grid-cols-3">
                    <div class="dark-stat">
                        <p class="text-3xl font-extrabold text-white">{{ $stats['liveListings'] }}</p>
                        <p class="mt-2 text-sm text-white/65">Live listings across cars, jobs, property and services.</p>
                    </div>
                    <div class="dark-stat">
                        <p class="text-3xl font-extrabold text-white">{{ $stats['verifiedSellers'] }}</p>
                        <p class="mt-2 text-sm text-white/65">Verified sellers ready to close on WhatsApp.</p>
                    </div>
                    <div class="dark-stat">
                        <p class="text-3xl font-extrabold text-white">{{ $stats['countries'] }}</p>
                        <p class="mt-2 text-sm text-white/65">East African markets covered from launch.</p>
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
                <div class="lg:hidden">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-[var(--color-sand)]">Marketplace</p>
                    <h1 class="mt-2 font-display text-3xl font-bold tracking-tight text-white">Find, post, chat, move.</h1>
                    <p class="mt-2 text-sm leading-6 text-white/62">Search first, browse fast, and act without getting lost in extra content.</p>
                </div>

                <form method="GET" action="{{ route('home') }}" class="hero-panel space-y-5 rounded-[2rem] p-5 text-white md:p-6" data-country-city-filter data-country-city-map='@json($countryCityMap)'>
                    <div class="border-b border-white/8 pb-4">
                        <p class="section-heading">Explore Connectify</p>
                        <h2 class="mt-2 font-display text-2xl font-bold text-white">Find your next move</h2>
                        <p class="mt-2 text-sm text-white/60">Premium browsing, verified sellers, faster WhatsApp conversations.</p>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <label class="space-y-2">
                            <span class="block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/58">Country</span>
                            <select name="country" class="connectify-input" data-country-select>
                                <option value="">All countries</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country }}" @selected($filters['country'] === $country)>{{ $country }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="space-y-2 sm:col-span-2">
                            <span class="block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/58">City</span>
                            <select name="city" class="connectify-input" data-city-select @disabled(blank($filters['country']))>
                                <option value="">{{ $filters['country'] ? 'All cities' : 'Choose country first' }}</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city }}" @selected($filters['city'] === $city)>{{ $city }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="space-y-2 sm:col-span-2">
                            <span class="block text-[11px] font-semibold uppercase tracking-[0.18em] text-white/58">Category</span>
                            <select name="type" class="connectify-input">
                                <option value="">All categories</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->value }}" @selected($filters['type'] === $type->value)>{{ $type->label() }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div>
                        <p class="mb-3 text-xs font-semibold uppercase tracking-[0.22em] text-white/55">Choose intent</p>
                        <div class="grid grid-cols-1 gap-3 text-sm sm:grid-cols-3 sm:text-center">
                            <label class="cursor-pointer">
                                <input type="radio" name="transaction_type" value="rent" class="peer sr-only" @checked($filters['transaction_type'] === 'rent')>
                                <span class="block rounded-2xl border border-white/8 bg-white/5 px-4 py-4 transition peer-checked:border-[rgba(29,143,255,0.45)] peer-checked:bg-[rgba(29,143,255,0.14)] peer-checked:shadow-[0_18px_40px_-24px_rgba(29,143,255,0.7)] sm:px-3">
                                    <span class="font-bold text-white">Rent</span>
                                    <span class="mt-1 block text-xs text-white/55">Homes and cars</span>
                                </span>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="transaction_type" value="sale" class="peer sr-only" @checked($filters['transaction_type'] === 'sale')>
                                <span class="block rounded-2xl border border-white/8 bg-white/5 px-4 py-4 transition peer-checked:border-[rgba(29,143,255,0.45)] peer-checked:bg-[rgba(29,143,255,0.14)] peer-checked:shadow-[0_18px_40px_-24px_rgba(29,143,255,0.7)] sm:px-3">
                                    <span class="font-bold text-white">Buy</span>
                                    <span class="mt-1 block text-xs text-white/55">Vehicles and property</span>
                                </span>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="transaction_type" value="hire" class="peer sr-only" @checked($filters['transaction_type'] === 'hire')>
                                <span class="block rounded-2xl border border-white/8 bg-white/5 px-4 py-4 transition peer-checked:border-[rgba(29,143,255,0.45)] peer-checked:bg-[rgba(29,143,255,0.14)] peer-checked:shadow-[0_18px_40px_-24px_rgba(29,143,255,0.7)] sm:px-3">
                                    <span class="font-bold text-white">Hire</span>
                                    <span class="mt-1 block text-xs text-white/55">Jobs and talent</span>
                                </span>
                            </label>
                        </div>
                        @if ($filters['transaction_type'])
                            <div class="mt-3">
                                <a href="{{ route('home', collect($filters)->except('transaction_type')->filter()->all()) }}" class="text-xs font-semibold uppercase tracking-[0.18em] text-white/60 transition hover:text-white">Clear intent</a>
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="primary-cta w-full">Search marketplace</button>
                </form>

                <section id="mobile-utility" class="hero-panel rounded-[2rem] p-4 text-white lg:hidden">
                    <div class="mb-3 flex items-end justify-between gap-3 border-b border-white/8 pb-3">
                        <div>
                            <p class="section-heading !text-[var(--color-sand)]">Quick actions</p>
                            <h2 class="mt-2 font-display text-xl font-bold text-white">Move faster</h2>
                        </div>
                        <p class="max-w-[8rem] text-right text-xs leading-5 text-white/58">Jump straight into the work that matters.</p>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('home', ['type' => 'vehicle']) }}" class="rounded-[1.5rem] border border-white/12 bg-[linear-gradient(180deg,rgba(255,255,255,0.12),rgba(255,255,255,0.06))] px-3 py-4 text-center text-white transition hover:bg-[linear-gradient(180deg,rgba(255,255,255,0.16),rgba(255,255,255,0.08))]">
                            <span class="block text-xs font-semibold uppercase tracking-[0.18em] text-[var(--color-sand)]">01</span>
                            <span class="mt-2 block text-sm font-bold text-white">Vehicles</span>
                        </a>
                        <a href="{{ route('home', ['type' => 'property']) }}" class="rounded-[1.5rem] border border-white/12 bg-[linear-gradient(180deg,rgba(255,255,255,0.12),rgba(255,255,255,0.06))] px-3 py-4 text-center text-white transition hover:bg-[linear-gradient(180deg,rgba(255,255,255,0.16),rgba(255,255,255,0.08))]">
                            <span class="block text-xs font-semibold uppercase tracking-[0.18em] text-[var(--color-sand)]">02</span>
                            <span class="mt-2 block text-sm font-bold text-white">Homes</span>
                        </a>
                        <a href="{{ route('home', ['type' => 'job']) }}" class="rounded-[1.5rem] border border-white/12 bg-[linear-gradient(180deg,rgba(255,255,255,0.12),rgba(255,255,255,0.06))] px-3 py-4 text-center text-white transition hover:bg-[linear-gradient(180deg,rgba(255,255,255,0.16),rgba(255,255,255,0.08))]">
                            <span class="block text-xs font-semibold uppercase tracking-[0.18em] text-[var(--color-sand)]">03</span>
                            <span class="mt-2 block text-sm font-bold text-white">Jobs</span>
                        </a>
                        <a href="/seller/register" class="rounded-[1.5rem] border border-[rgba(29,143,255,0.35)] bg-[linear-gradient(180deg,rgba(29,143,255,0.24),rgba(29,143,255,0.12))] px-3 py-4 text-center text-white transition hover:bg-[linear-gradient(180deg,rgba(29,143,255,0.28),rgba(29,143,255,0.14))]">
                            <span class="block text-xs font-semibold uppercase tracking-[0.18em] text-[var(--color-sand)]">04</span>
                            <span class="mt-2 block text-sm font-bold text-white">Post ad</span>
                        </a>
                    </div>
                </section>

                @if ($heroListing)
                    <a href="{{ route('listings.show', $heroListing) }}" class="hero-panel hidden overflow-hidden rounded-[2rem] p-4 transition hover:-translate-y-1 md:p-5 lg:block">
                        <div class="relative overflow-hidden rounded-[1.5rem]">
                            <img src="{{ $heroListing->cover_image }}" alt="{{ $heroListing->title }}" class="h-64 w-full object-cover">
                            <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(9,11,15,0.08),rgba(9,11,15,0.82))]"></div>
                            <div class="absolute inset-x-0 bottom-0 p-5">
                                <span class="gold-chip">Featured</span>
                                <h3 class="mt-3 font-display text-2xl font-bold text-white">{{ $heroListing->title }}</h3>
                                <div class="mt-3 flex items-end justify-between gap-4">
                                    <div>
                                        <p class="text-xl font-extrabold text-white">{{ $heroListing->formattedPrimaryValue() }}</p>
                                        <p class="text-sm text-white/65">{{ $heroListing->city }}, {{ $heroListing->country }}</p>
                                    </div>
                                    <span class="rounded-full border border-white/12 bg-white/10 px-4 py-2 text-sm font-semibold text-white">View deal</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endif
            </div>
        </section>

        <section id="categories" class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="mb-5 flex items-end justify-between gap-4">
                <div>
                    <p class="section-heading">Core verticals</p>
                    <h2 class="mt-2 font-display text-2xl font-bold text-[var(--color-ink)] sm:text-3xl">Browse the marketplace like a product, not a noticeboard</h2>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                @foreach ($types as $type)
                    <a href="{{ route('home', ['type' => $type->value]) }}" class="surface-card group rounded-[1.5rem] p-4 text-[var(--color-ink)] shadow-[0_20px_50px_-30px_rgba(8,20,33,0.35)] transition hover:-translate-y-1 hover:border-[var(--color-ocean)] sm:rounded-[1.75rem] sm:p-6">
                        <p class="section-heading">{{ $type->value }}</p>
                        <h3 class="mt-3 font-display text-xl font-bold sm:text-2xl">{{ $type->label() }}</h3>
                        <p class="mt-3 hidden text-sm leading-6 text-slate-600 sm:block">{{ match($type->value) {
                            'vehicle' => 'Sell and discover cars ready for city roads and cross-border travel.',
                            'property' => 'Browse homes, rentals and commercial spaces in prime neighborhoods.',
                            'job' => 'Reach serious employers and job seekers across the region.',
                            default => 'List trusted services, rentals and specialist business offerings.',
                        } }}</p>
                        <div class="mt-4 flex items-center justify-between sm:mt-6">
                            <span class="inline-flex text-sm font-semibold text-[var(--color-ocean)]">Browse now</span>
                            <span class="text-lg text-[var(--color-clay)]">01</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <section id="why-connectify" class="mx-auto hidden max-w-7xl px-4 py-10 sm:px-6 lg:block lg:px-8">
            <div class="hero-panel rounded-[2rem] px-6 py-8 md:px-8">
                <div class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
                    <div>
                        <p class="gold-chip">Why Connectify?</p>
                        <h2 class="mt-4 max-w-xl font-display text-3xl font-bold text-white md:text-4xl">One marketplace for trusted cars, homes, jobs and business services across East Africa.</h2>
                        <p class="mt-4 max-w-lg text-sm leading-7 text-white/65">Connectify helps buyers and renters move faster with verified listings, clear location filters, direct WhatsApp contact, and a regional inventory that starts in Rwanda and extends into Uganda, Burundi, DRC, Kenya, Tanzania, and South Sudan.</p>
                    </div>
                    <div class="grid gap-4 md:grid-cols-3">
                        <div class="rounded-[1.5rem] border border-white/8 bg-white/6 p-5">
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[var(--color-sand)]">01</p>
                            <h3 class="mt-4 font-display text-xl font-bold text-white">Verified sellers</h3>
                            <p class="mt-3 text-sm leading-6 text-white/60">Every featured seller profile can include business identity, WhatsApp details, and listing history so buyers know who they are dealing with before they enquire.</p>
                        </div>
                        <div class="rounded-[1.5rem] border border-white/8 bg-white/6 p-5">
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[var(--color-sand)]">02</p>
                            <h3 class="mt-4 font-display text-xl font-bold text-white">Location-first discovery</h3>
                            <p class="mt-3 text-sm leading-6 text-white/60">Choose a country first, then filter by real cities to see inventory that actually matches where you want to buy, rent, hire or relocate.</p>
                        </div>
                        <div class="rounded-[1.5rem] border border-white/8 bg-white/6 p-5">
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[var(--color-sand)]">03</p>
                            <h3 class="mt-4 font-display text-xl font-bold text-white">WhatsApp conversion</h3>
                            <p class="mt-3 text-sm leading-6 text-white/60">Instead of losing buyers in long forms, Connectify pushes serious enquiries straight into WhatsApp for viewings, negotiations, tenancy questions and hiring follow-up.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="featured" class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <p class="section-heading">Featured listings</p>
                    <h2 class="mt-2 font-display text-3xl font-bold text-[var(--color-ink)]">High-intent listings worth viewing first</h2>
                </div>
                <a href="/admin" class="hidden rounded-full border border-[var(--color-sand)] bg-white/70 px-4 py-2 text-sm font-semibold text-[var(--color-ink)] shadow-[0_18px_32px_-22px_rgba(8,20,33,0.4)] md:inline-flex">Admin Panel</a>
            </div>

            <div class="mt-6 grid gap-5 lg:grid-cols-[1.15fr_0.85fr]">
                @if ($heroListing)
                    <article class="relative overflow-hidden rounded-[2rem] bg-[var(--color-ink)] text-white shadow-[0_30px_80px_-38px_rgba(0,0,0,0.7)]">
                        <img src="{{ $heroListing->cover_image }}" alt="{{ $heroListing->title }}" class="h-full min-h-[28rem] w-full object-cover">
                        <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(9,11,15,0.92),rgba(9,11,15,0.38),rgba(9,11,15,0.72))]"></div>
                        <div class="absolute inset-0 flex flex-col justify-between p-7 md:p-9">
                            <div class="flex items-start justify-between gap-4">
                                <span class="gold-chip">Featured listing</span>
                                @if ($heroListing->is_verified)
                                    <span class="rounded-full border border-white/12 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-white">Verified seller</span>
                                @endif
                            </div>
                            <div class="max-w-xl">
                                <p class="text-sm uppercase tracking-[0.24em] text-[var(--color-sand)]">{{ $heroListing->type->label() }}</p>
                                <h3 class="mt-3 font-display text-3xl font-bold md:text-5xl">{{ $heroListing->title }}</h3>
                                <p class="mt-4 max-w-lg text-sm leading-7 text-white/70">{{ \Illuminate\Support\Str::limit($heroListing->description, 180) }}</p>
                                <div class="mt-6 flex flex-wrap items-end gap-4">
                                    <div>
                                        <p class="text-3xl font-extrabold text-white">{{ $heroListing->formattedPrimaryValue() }}</p>
                                        <p class="mt-1 text-sm text-white/60">{{ $heroListing->city }}, {{ $heroListing->country }}</p>
                                    </div>
                                    <a href="{{ route('listings.show', $heroListing) }}" class="primary-cta">Open listing</a>
                                </div>
                            </div>
                        </div>
                    </article>
                @endif

                <div class="grid gap-5">
                    @foreach ($heroSideListings as $listing)
                        <article class="surface-card overflow-hidden rounded-[2rem] text-[var(--color-ink)]">
                            <div class="grid gap-0 md:grid-cols-[0.42fr_0.58fr]">
                                <img src="{{ $listing->cover_image }}" alt="{{ $listing->title }}" class="h-full min-h-52 w-full object-cover">
                                <div class="p-6">
                                    <div class="flex items-center justify-between gap-4">
                                        <span class="rounded-full bg-[var(--color-mist)] px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-[var(--color-clay)]">{{ $listing->type->label() }}</span>
                                        <span class="text-xs uppercase tracking-[0.18em] text-slate-500">{{ ucfirst($listing->transaction_type) }}</span>
                                    </div>
                                    <h3 class="mt-4 font-display text-2xl font-bold"><a href="{{ route('listings.show', $listing) }}">{{ $listing->title }}</a></h3>
                                    <p class="mt-3 text-sm leading-6 text-slate-600">{{ \Illuminate\Support\Str::limit($listing->description, 110) }}</p>
                                    <div class="mt-5 flex items-end justify-between gap-4">
                                        <div>
                                            <p class="text-xl font-extrabold">{{ $listing->formattedPrimaryValue() }}</p>
                                            <p class="text-sm text-slate-500">{{ $listing->city }}, {{ $listing->country }}</p>
                                        </div>
                                        <a href="{{ $listing->whatsappUrl() }}" target="_blank" class="inline-flex items-center justify-center rounded-full bg-[linear-gradient(135deg,var(--color-leaf),#31b98b)] px-4 py-2 text-sm font-semibold text-white shadow-[0_18px_40px_-20px_rgba(22,149,107,0.8)]">WhatsApp</a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="latest" class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">
            <div class="surface-card rounded-[2rem] p-6 text-[var(--color-ink)] md:p-8">
                <div class="flex flex-col gap-3 border-b border-slate-200 pb-6 md:flex-row md:items-end md:justify-between">
                    <div>
                        <p class="section-heading">Latest listings</p>
                        <h2 class="mt-2 font-display text-3xl font-bold">Fresh from the marketplace</h2>
                    </div>
                    <p class="max-w-xl text-sm leading-6 text-slate-600">New stock, rentals, job posts and service offers appear here first, giving buyers and applicants a current view of what is available in their selected country and city.</p>
                </div>

                <div class="mt-6 grid gap-4 lg:grid-cols-3">
                    @forelse ($listings as $listing)
                        <article class="surface-card-soft rounded-[1.5rem] p-4 transition hover:-translate-y-1 hover:border-[var(--color-ocean)] hover:shadow-lg">
                            <img src="{{ $listing->cover_image }}" alt="{{ $listing->title }}" class="h-48 w-full rounded-[1.25rem] object-cover">
                            <div class="mt-4 flex items-center justify-between gap-3">
                                <span class="rounded-full bg-[var(--color-mist)] px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-[var(--color-clay)]">{{ $listing->type->label() }}</span>
                                <span class="text-xs text-slate-500">{{ $listing->area ?? $listing->city }}</span>
                            </div>
                            <h3 class="mt-3 font-display text-xl font-bold"><a href="{{ route('listings.show', $listing) }}">{{ $listing->title }}</a></h3>
                            <p class="mt-2 text-sm text-slate-500">{{ $listing->city }}, {{ $listing->country }}</p>
                            <p class="mt-3 text-sm leading-6 text-slate-600">{{ \Illuminate\Support\Str::limit($listing->description, 100) }}</p>
                            <div class="mt-4 flex items-center justify-between gap-3">
                                <div>
                                    <p class="text-lg font-extrabold">{{ $listing->formattedPrimaryValue() }}</p>
                                    <p class="text-xs uppercase tracking-[0.18em] text-slate-500">{{ $listing->seller?->company_name ?? $listing->seller?->name }}</p>
                                </div>
                                <a href="{{ route('listings.show', $listing) }}" class="rounded-full border border-[var(--color-sand)] bg-white/70 px-4 py-2 text-sm font-semibold shadow-[0_12px_24px_-18px_rgba(8,20,33,0.4)]">View</a>
                            </div>
                        </article>
                    @empty
                        <div class="lg:col-span-3">
                            <div class="surface-card-soft rounded-[1.5rem] border-dashed px-6 py-12 text-center">
                                <h3 class="font-display text-2xl font-bold">No listings match your filters</h3>
                                <p class="mt-2 text-sm text-slate-600">Try a different country or city, broaden your category, or publish a new listing from the seller panel to start building local inventory.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="mt-6">{{ $listings->links() }}</div>
            </div>
        </section>
    </main>
</x-layouts.app>