<x-layouts.app :title="$type->label() . ' | Connectify Marketplace'">
    <div class="relative min-h-screen bg-[var(--color-paper-strong)]">
        <!-- Original Navbar -->
        <header class="fixed inset-x-0 top-0 z-50 px-4 pt-6 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <div class="glass-panel flex items-center justify-between rounded-full px-4 py-3 md:px-6">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-full bg-[linear-gradient(135deg,var(--color-ocean),#8fd0ff)] text-lg font-black text-[var(--color-ink)]">
                            C</div>
                        <div>
                            <p class="font-display text-lg font-bold tracking-tight text-white">connectify</p>
                            <p class="text-xs uppercase tracking-[0.24em] text-white/60">Premium marketplace across
                                East Africa</p>
                        </div>
                    </a>
                    <nav class="hidden items-center gap-8 text-sm font-semibold md:flex text-white/80">
                        <a href="{{ route('home') }}" class="transition hover:text-white">Marketplace</a>
                        @foreach(App\Enums\ListingType::cases() as $navType)
                        <a href="{{ route('category.show', $navType->value) }}"
                            class="transition hover:text-white {{ $type === $navType ? 'text-white underline underline-offset-8' : '' }}">
                            {{ $navType->label() }}
                        </a>
                        @endforeach
                    </nav>
                    <div class="flex items-center gap-2">
                        <a href="/seller"
                            class="rounded-full border border-white/15 bg-white/95 px-5 py-2.5 text-sm font-bold text-[var(--color-ink)] transition hover:-translate-y-0.5">
                            Seller Panel</a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Immersive Hero -->
        <section
            class="relative overflow-hidden bg-[#040914] bg-gradient-to-b from-[#040914] via-[var(--color-night)] to-[var(--color-deep)] pb-40 pt-32 text-white md:pb-48 md:pt-44">
            <!-- Decorative orbs for premium feel -->
            <div
                class="absolute left-[10%] top-[20%] h-64 w-64 rounded-full bg-[var(--color-ocean)]/20 blur-[100px] pointer-events-none">
            </div>
            <div
                class="absolute right-[10%] top-[30%] h-72 w-72 rounded-full bg-[#8fd0ff]/10 blur-[100px] pointer-events-none">
            </div>

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <nav
                    class="flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-[var(--color-sand)]">
                    <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="text-white">{{ $type->label() }}</span>
                </nav>
                <h1 class="mt-8 font-display text-5xl font-extrabold tracking-tight md:text-7xl drop-shadow-lg">{{
                    $type->label() }}</h1>
                <p class="mt-6 max-w-2xl text-lg leading-relaxed text-white/80 md:text-xl font-medium">
                    Explore premium {{ strtolower($type->label()) }} listings across East Africa with trusted discovery
                    and direct WhatsApp contact.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <div
                        class="flex items-center gap-3 rounded-3xl bg-white/10 px-5 py-3 backdrop-blur-md border border-white/10 shadow-lg">
                        <span class="text-2xl font-black text-[#8fd0ff]">{{ $listings->total() }}</span>
                        <span
                            class="text-[10px] font-bold uppercase tracking-widest text-white/70 leading-tight">Verified<br>Listings</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Horizontal Quick Filter Bar -->
        <section class="relative z-20 -mt-12 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="glass-panel overflow-hidden rounded-[2.5rem] p-2 shadow-2xl">
                <form action="{{ route('category.show', $type->value) }}" method="GET"
                    class="flex flex-col gap-2 md:flex-row md:items-center">
                    <div class="flex-1 grid grid-cols-1 gap-2 p-1 sm:grid-cols-3">
                        <!-- Transaction Type -->
                        <div class="relative">
                            <select name="transaction_type" onchange="this.form.submit()"
                                class="w-full appearance-none rounded-3xl border border-slate-200 bg-white px-6 py-4 pr-10 text-sm font-bold text-[var(--color-ink)] shadow-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-ocean)]">
                                <option value="">All Intent</option>
                                <option value="sale" {{ ($filters['transaction_type'] ?? '' )==='sale' ? 'selected' : ''
                                    }}>To Buy</option>
                                <option value="rent" {{ ($filters['transaction_type'] ?? '' )==='rent' ? 'selected' : ''
                                    }}>To Rent</option>
                                <option value="hire" {{ ($filters['transaction_type'] ?? '' )==='hire' ? 'selected' : ''
                                    }}>To Hire</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-slate-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        <!-- Country -->
                        <div class="relative">
                            <select name="country" onchange="this.form.submit()"
                                class="w-full appearance-none rounded-3xl border border-slate-200 bg-white px-6 py-4 pr-10 text-sm font-bold text-[var(--color-ink)] shadow-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-ocean)]">
                                <option value="">Regions</option>
                                @foreach($countries as $country)
                                <option value="{{ $country }}" {{ ($filters['country'] ?? '' )===$country ? 'selected'
                                    : '' }}>{{ $country }}</option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-slate-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        <!-- City -->
                        <div class="relative">
                            <select name="city" onchange="this.form.submit()"
                                class="w-full appearance-none rounded-3xl border border-slate-200 bg-white px-6 py-4 pr-10 text-sm font-bold text-[var(--color-ink)] shadow-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-ocean)]">
                                <option value="">All Cities</option>
                                @foreach($cities as $city)
                                <option value="{{ $city }}" {{ ($filters['city'] ?? '' )===$city ? 'selected' : '' }}>{{
                                    $city }}</option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-slate-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 p-1">
                        <div class="relative flex-1">
                            <input type="text" name="q" value="{{ $filters['q'] ?? '' }}"
                                placeholder="Search specifically..."
                                class="w-full rounded-3xl border border-slate-200 bg-white px-6 py-[1.125rem] text-sm text-[var(--color-ink)] placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-ocean)]">
                        </div>
                        <button type="submit"
                            class="flex h-[3.5rem] w-[3.5rem] flex-shrink-0 items-center justify-center rounded-3xl bg-[var(--color-ocean)] text-white shadow-lg transition hover:scale-105">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Main Browsing Area -->
        <main class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-[280px_1fr]">
                <!-- Advanced Filters Sidebar -->
                <aside class="space-y-8">
                    <!-- Current Selection / Pills -->
                    @php
                    $activeFilters = collect($filters)->filter(fn($v, $k) => $v && !in_array($k, ['type']));
                    @endphp
                    @if($activeFilters->isNotEmpty())
                    <div>
                        <div class="flex items-center justify-between px-1">
                            <h3 class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Active
                                Filters
                            </h3>
                            <a href="{{ route('category.show', $type->value) }}"
                                class="text-[10px] font-bold text-[var(--color-clay)] hover:underline">Clear all</a>
                        </div>
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach($activeFilters as $key => $val)
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-white px-3 py-1.5 text-[10px] font-bold shadow-sm border border-slate-100">
                                {{ ucfirst(str_replace('_', ' ', $val)) }}
                                <a href="{{ route('category.show', [$type->value] + collect($filters)->except($key)->filter()->all()) }}"
                                    class="text-slate-400 hover:text-red-500">
                                    <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                    </svg>
                                </a>
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Price Range Card -->
                    <div class="surface-card rounded-[2.5rem] p-6 shadow-sm border border-slate-100/50 bg-white">
                        <h3 class="font-display text-lg font-bold text-[var(--color-ink)]">Price Range</h3>
                        <form action="{{ route('category.show', $type->value) }}" method="GET" class="mt-6 space-y-4">
                            @foreach($filters as $k => $v)
                            @if(!in_array($k, ['min_price', 'max_price']))
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                            @endif
                            @endforeach
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <span
                                        class="text-[10px] font-bold uppercase tracking-widest text-[#6f8da9]">Min</span>
                                    <input type="number" name="min_price" value="{{ $filters['min_price'] ?? '' }}"
                                        placeholder="0"
                                        class="mt-1 w-full rounded-2xl border border-[#d6e6f6] bg-slate-50 px-4 py-3 text-sm font-medium text-[var(--color-ink)] focus:border-[var(--color-ocean)] focus:ring-[var(--color-ocean)] outline-none transition">
                                </div>
                                <div>
                                    <span
                                        class="text-[10px] font-bold uppercase tracking-widest text-[#6f8da9]">Max</span>
                                    <input type="number" name="max_price" value="{{ $filters['max_price'] ?? '' }}"
                                        placeholder="Any"
                                        class="mt-1 w-full rounded-2xl border border-[#d6e6f6] bg-slate-50 px-4 py-3 text-sm font-medium text-[var(--color-ink)] focus:border-[var(--color-ocean)] focus:ring-[var(--color-ocean)] outline-none transition">
                                </div>
                            </div>
                            <button type="submit"
                                class="mt-2 w-full rounded-2xl bg-[var(--color-deep)] py-3.5 text-xs font-bold uppercase tracking-widest text-white shadow-md hover:bg-[var(--color-ink)] transition hover:-translate-y-0.5">Apply
                                Range</button>
                        </form>
                    </div>

                    <!-- Verified Only Switch -->
                    <div
                        class="surface-card rounded-[2.5rem] p-6 shadow-sm border border-slate-100/50 bg-white flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-bold text-[var(--color-ink)]">Verified Only</h3>
                            <p class="text-[10px] font-medium text-[#6f8da9] mt-0.5">Show trusted sellers</p>
                        </div>
                        <button class="h-6 w-11 rounded-full bg-slate-200 p-1 transition-colors hover:bg-slate-300">
                            <div class="h-4 w-4 rounded-full bg-white shadow-sm transition-transform"></div>
                        </button>
                    </div>
                </aside>

                <!-- Listing Grid & Results Header -->
                <div class="space-y-8">
                    <!-- Header Bar -->
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-[var(--color-clay)] mb-2">
                                Category</p>
                            <h2 class="font-display text-3xl font-extrabold text-[var(--color-ink)]">Showing Result</h2>
                            <p class="text-sm text-[#6f8da9] mt-1 font-medium">Discover <span
                                    class="font-bold text-[var(--color-ink)]">{{ $listings->total() }}</span> available
                                listings in {{ $type->label() }}</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <select
                                    class="appearance-none rounded-full border border-slate-200 bg-white px-6 py-2.5 pr-10 text-xs font-bold text-[var(--color-ink)] shadow-sm focus:border-[var(--color-ocean)] focus:outline-none focus:ring-2 focus:ring-[var(--color-ocean)] transition">
                                    <option>Newest First</option>
                                    <option>Price: Low to High</option>
                                    <option>Price: High to Low</option>
                                </select>
                                <svg class="pointer-events-none absolute right-4 top-1/2 h-3 w-3 -translate-y-1/2 text-[var(--color-ink)]/50"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Grid -->
                    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                        @forelse ($listings as $listing)
                        <article
                            class="surface-card group overflow-hidden rounded-[2.5rem] p-3 transition hover:-translate-y-1 hover:shadow-xl relative">
                            <!-- Image Container -->
                            <div class="relative h-64 overflow-hidden rounded-[2rem]">
                                <img src="{{ $listing->cover_image }}" alt="{{ $listing->title }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-110">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 transition duration-300 group-hover:opacity-100">
                                </div>
                                <div
                                    class="absolute bottom-4 left-4 right-4 translate-y-4 opacity-0 transition duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                                    <a href="{{ route('listings.show', $listing) }}"
                                        class="inline-flex w-full items-center justify-center rounded-2xl bg-white/20 px-4 py-2 text-xs font-bold text-white backdrop-blur-xl hover:bg-white/30">View
                                        Details</a>
                                </div>
                                <div class="absolute right-4 top-4">
                                    @auth
                                    @php $isSaved = auth()->user()->savedListings->contains($listing->id); @endphp
                                    <form method="POST"
                                        action="{{ route($isSaved ? 'saved.destroy' : 'saved.store', $listing) }}">
                                        @csrf
                                        @if ($isSaved) @method('DELETE') @endif
                                        <button type="submit"
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-white/90 shadow-lg backdrop-blur transition hover:scale-110">
                                            <svg class="h-5 w-5 {{ $isSaved ? 'fill-red-500 text-red-500' : 'fill-none text-slate-600' }}"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                        </button>
                                    </form>
                                    @endauth
                                </div>
                                @if($listing->is_featured)
                                <div
                                    class="absolute left-4 top-4 rounded-full bg-[var(--color-sun)] px-3 py-1 text-[10px] font-black uppercase text-[var(--color-ink)] shadow-lg">
                                    Featured</div>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="px-3 pb-4 pt-5">
                                <div class="flex items-center justify-between gap-4">
                                    <span
                                        class="text-[10px] font-black uppercase tracking-widest text-[var(--color-clay)]">{{
                                        $listing->type->label() }}</span>
                                    <span class="text-[10px] font-bold text-slate-400 capitalize">{{
                                        $listing->transaction_type === 'hire' ? 'Employment' :
                                        $listing->transaction_type }}</span>
                                </div>
                                <h3 class="mt-3 font-display text-xl font-bold leading-7 text-[var(--color-ink)]">
                                    <a href="{{ route('listings.show', $listing) }}"
                                        class="hover:text-[var(--color-ocean)] transition line-clamp-1">{{
                                        $listing->title }}</a>
                                </h3>
                                <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-4">
                                    <div>
                                        <p class="text-lg font-black text-[var(--color-ink)]">{{
                                            $listing->formattedPrimaryValue }}</p>
                                        <p class="text-[10px] font-medium text-slate-400">{{ $listing->city }}, {{
                                            $listing->country }}</p>
                                    </div>
                                    @if($listing->is_verified)
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-50 text-emerald-600"
                                        title="Verified Seller">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </article>
                        @empty
                        <div class="sm:col-span-2 xl:col-span-3">
                            <div
                                class="flex flex-col items-center justify-center rounded-[3rem] border-2 border-dashed border-slate-200 bg-white/50 px-6 py-20 text-center">
                                <div
                                    class="flex h-20 w-20 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                    <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                                <h3 class="mt-6 font-display text-2xl font-bold text-slate-800">No matching listings
                                </h3>
                                <p class="mt-2 text-slate-500">Try adjusting your filters or search keywords to see
                                    more
                                    results.</p>
                                <a href="{{ route('category.show', $type->value) }}"
                                    class="mt-8 rounded-full bg-[var(--color-ink)] px-8 py-3 text-sm font-bold text-white shadow-xl hover:-translate-y-0.5 transition">Clear
                                    All Filters</a>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="pt-8">
                        {{ $listings->links() }}
                    </div>
                </div>
            </div>
        </main>

        <!-- Dynamic FAQ / Trust Section -->
        <section class="bg-white/40 py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-12 lg:grid-cols-3">
                    <div class="flex gap-6">
                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[var(--color-mist)] text-[var(--color-ocean)]">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04 بین 0 0 1-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-display text-xl font-bold">Verified Transactions</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-500">Every pro seller on Connectify is
                                vetted to ensure that images and descriptions match the real-world item.</p>
                        </div>
                    </div>
                    <div class="flex gap-6">
                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[var(--color-mist)] text-[var(--color-ocean)]">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-display text-xl font-bold">Direct Messaging</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-500">Connect instantly with sellers
                                via
                                WhatsApp. No middlemen, no hidden fees, just direct peer-to-peer conversation.</p>
                        </div>
                    </div>
                    <div class="flex gap-6">
                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[var(--color-mist)] text-[var(--color-ocean)]">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-display text-xl font-bold">Email Support</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-500">Need help? Our dedicated support team
                                is available via email to assist you with any questions or concerns.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-layouts.app>