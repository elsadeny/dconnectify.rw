<x-layouts.app :title="$type->label() . ' | Connectify Marketplace'">
    <div class="relative min-h-screen bg-[var(--color-mist)]">
        <!-- Vertical Header -->
        <header class="premium-hero-bg relative overflow-hidden py-16 text-white md:py-24">
            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col items-start justify-between gap-8 md:flex-row md:items-end">
                    <div>
                        <p class="section-heading !text-white/60">Explore vertical</p>
                        <h1 class="mt-4 font-display text-4xl font-bold md:text-6xl">{{ $type->label() }}</h1>
                        <p class="mt-6 max-w-2xl text-lg text-white/70">
                            {{ match($type->value) {
                            'vehicle' => 'Discover the best certified and locally used vehicles across East Africa.',
                            'property' => 'Premium real estate listings including residential homes, rentals, and
                            commercial land.',
                            'job' => 'Professional career opportunities and specialist roles in growing industries.',
                            default => 'Trusted services and specialist business offerings categorized for your
                            convenience.',
                            } }}
                        </p>
                    </div>
                    <div class="flex items-center gap-4">
                        <span
                            class="rounded-full border border-white/20 bg-white/10 px-6 py-3 text-sm font-semibold backdrop-blur">
                            {{ $listings->total() }} Active Listings
                        </span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content with Filter Sidebar -->
        <main class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-[300px_1fr]">
                <!-- Filter Sidebar -->
                <aside class="space-y-8">
                    <div class="surface-card rounded-[2.5rem] p-6 shadow-[0_32px_90px_-30px_rgba(8,20,33,0.15)]">
                        <h2 class="font-display text-xl font-bold">Refine Results</h2>

                        <form method="GET" action="{{ route('category.show', $type->value) }}" class="mt-8 space-y-6">
                            <div class="space-y-5">
                                <label class="block">
                                    <span
                                        class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Keyword</span>
                                    <input type="text" name="q" value="{{ $filters['q'] ?? '' }}"
                                        placeholder="Search {{ strtolower($type->label()) }}..."
                                        class="mt-2 w-full rounded-2xl border-slate-100 bg-slate-50/50 px-4 py-3.5 text-sm transition focus:border-[var(--color-ocean)] focus:ring-[var(--color-ocean)]">
                                </label>

                                <label class="block">
                                    <span
                                        class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Country</span>
                                    <select name="country"
                                        class="mt-2 w-full rounded-2xl border-slate-100 bg-slate-50/50 px-4 py-3.5 text-sm transition focus:border-[var(--color-ocean)] focus:ring-[var(--color-ocean)]">
                                        <option value="">All Regions</option>
                                        @foreach($countries as $country)
                                        <option value="{{ $country }}" {{ ($filters['country'] ?? '' )===$country
                                            ? 'selected' : '' }}>{{ $country }}</option>
                                        @endforeach
                                    </select>
                                </label>

                                <div class="grid grid-cols-2 gap-3">
                                    <label class="block">
                                        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Min
                                            Price</span>
                                        <input type="number" name="min_price" value="{{ $filters['min_price'] ?? '' }}"
                                            placeholder="0"
                                            class="mt-2 w-full rounded-2xl border-slate-100 bg-slate-50/50 px-4 py-3.5 text-sm transition focus:border-[var(--color-ocean)] focus:ring-[var(--color-ocean)]">
                                    </label>
                                    <label class="block">
                                        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Max
                                            Price</span>
                                        <input type="number" name="max_price" value="{{ $filters['max_price'] ?? '' }}"
                                            placeholder="Any"
                                            class="mt-2 w-full rounded-2xl border-slate-100 bg-slate-50/50 px-4 py-3.5 text-sm transition focus:border-[var(--color-ocean)] focus:ring-[var(--color-ocean)]">
                                    </label>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full rounded-2xl bg-[var(--color-ink)] py-4 text-sm font-bold text-white shadow-[0_18px_32px_-12px_rgba(8,20,33,0.4)] transition hover:-translate-y-0.5 active:scale-95">
                                Apply Filters
                            </button>

                            @if(count($filters) > 1)
                            <a href="{{ route('category.show', $type->value) }}"
                                class="block text-center text-xs font-semibold text-slate-400 hover:text-slate-600">
                                Reset all filters
                            </a>
                            @endif
                        </form>
                    </div>

                    <!-- Trust Card -->
                    <div class="rounded-[2rem] bg-[var(--color-ocean)] p-6 text-white shadow-lg shadow-blue-500/20">
                        <h3 class="font-display text-lg font-bold">Safe Browsing</h3>
                        <p class="mt-3 text-sm leading-relaxed text-white/80">Connectify verifies top sellers in this
                            category to ensure you get exactly what you see. Always confirm details on WhatsApp.</p>
                    </div>
                </aside>

                <!-- Listing Grid -->
                <section>
                    <div class="mb-8 flex items-center justify-between">
                        <p class="text-sm text-slate-500">Showing <span class="font-bold text-slate-900">{{
                                $listings->firstItem() ?? 0 }}-{{ $listings->lastItem() ?? 0 }}</span> of {{
                            $listings->total() }} results</p>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-slate-400 uppercase">Sort by:</span>
                            <select
                                class="border-none bg-transparent text-sm font-bold text-slate-900 focus:ring-0 cursor-pointer">
                                <option>Newest First</option>
                                <option>Price: Low to High</option>
                                <option>Price: High to Low</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        @forelse ($listings as $listing)
                        <article
                            class="surface-card-soft rounded-[2rem] p-4 transition-all hover:-translate-y-1 hover:border-[var(--color-ocean)] hover:shadow-xl relative group">
                            @auth
                            @php $isSaved = auth()->user()->savedListings->contains($listing->id); @endphp
                            <form method="POST"
                                action="{{ route($isSaved ? 'saved.destroy' : 'saved.store', $listing) }}"
                                class="absolute top-6 right-6 z-20 opacity-0 group-hover:opacity-100 transition-opacity">
                                @csrf
                                @if ($isSaved) @method('DELETE') @endif
                                <button type="submit"
                                    class="rounded-full bg-white/95 p-3 shadow-xl backdrop-blur-md transition hover:scale-110">
                                    <svg class="h-5 w-5 {{ $isSaved ? 'fill-red-500 text-red-500' : 'fill-none text-slate-400' }}"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                            @endauth

                            <a href="{{ route('listings.show', $listing) }}" class="block">
                                <img src="{{ $listing->cover_image }}" alt="{{ $listing->title }}"
                                    class="aspect-[4/3] w-full rounded-[1.5rem] object-cover">
                                <div class="mt-5 space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-bold text-[var(--color-ocean)]">{{
                                            $listing->formattedPrimaryValue() }}</span>
                                        <span class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">{{
                                            $listing->city }}</span>
                                    </div>
                                    <h3
                                        class="font-display text-lg font-bold text-slate-900 group-hover:text-[var(--color-ocean)] transition-colors">
                                        {{ $listing->title }}</h3>
                                    <p class="text-sm leading-relaxed text-slate-500 line-clamp-2">
                                        {{ \Illuminate\Support\Str::limit($listing->description, 90) }}
                                    </p>
                                    <div class="pt-4 flex items-center justify-between border-t border-slate-100">
                                        <div class="flex items-center gap-2">
                                            <div class="h-6 w-6 rounded-full bg-slate-200"></div>
                                            <span class="text-xs font-semibold text-slate-600">{{
                                                $listing->seller?->name }}</span>
                                        </div>
                                        <span class="text-[10px] font-bold uppercase tracking-tighter text-slate-400">{{
                                            $listing->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </a>
                        </article>
                        @empty
                        <div class="col-span-full flex flex-col items-center justify-center py-20 text-center">
                            <div class="rounded-full bg-slate-100 p-6">
                                <svg class="h-10 w-10 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <h3 class="mt-6 font-display text-xl font-bold text-slate-900">No listings found</h3>
                            <p class="mt-2 text-slate-500">We couldn't find any {{ strtolower($type->label()) }}
                                matching your current filters.</p>
                            <a href="{{ route('category.show', $type->value) }}"
                                class="mt-8 font-bold text-[var(--color-ocean)] underline underline-offset-8">Clear all
                                filters</a>
                        </div>
                        @endforelse
                    </div>

                    <div class="mt-12">
                        {{ $listings->links() }}
                    </div>
                </section>
            </div>
        </main>
    </div>
</x-layouts.app>