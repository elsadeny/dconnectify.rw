<x-layouts.app :title="$listing->title.' | connectify'">
    <div class="premium-hero-bg pt-24 pb-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}"
                class="inline-flex items-center rounded-full border border-white/15 bg-white/10 px-5 py-2.5 text-sm font-semibold text-white backdrop-blur transition hover:bg-white/20">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to marketplace
            </a>

            <div class="mt-8 flex flex-wrap items-center gap-4">
                <span class="gold-chip">Premium listing</span>
                <span class="text-sm font-medium tracking-wide text-white/60">Listed {{ $listing->created_at->format('M
                    d, Y') }}</span>
            </div>
            <h1 class="mt-4 font-display text-4xl font-bold text-white md:text-6xl lg:max-w-4xl">{{ $listing->title }}
            </h1>
        </div>
    </div>

    <main class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">

        <div class="mt-6 grid gap-8 lg:grid-cols-[1.25fr_0.75fr]">
            <section class="space-y-6">
                <div class="overflow-hidden rounded-[2rem] bg-white shadow-[0_25px_70px_-35px_rgba(8,20,33,0.6)]">
                    <img src="{{ $listing->cover_image }}" alt="{{ $listing->title }}"
                        class="h-[22rem] w-full object-cover sm:h-[30rem]">
                    @if (filled($listing->gallery))
                    <div class="grid grid-cols-2 gap-3 p-4 md:grid-cols-3">
                        @foreach ($listing->gallery as $image)
                        <img src="{{ $image }}" alt="{{ $listing->title }} gallery image"
                            class="h-32 w-full rounded-2xl object-cover">
                        @endforeach
                    </div>
                    @endif
                </div>

                <div
                    class="rounded-[2.5rem] bg-white p-6 text-[var(--color-ink)] shadow-[0_32px_90px_-30px_rgba(8,20,33,0.3)] md:p-8">
                    <div class="flex flex-wrap items-center gap-3">
                        <span
                            class="rounded-full bg-[var(--color-mist)] px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-[var(--color-clay)]">{{
                            $listing->type->label() }}</span>
                        <span
                            class="rounded-full bg-slate-100 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-slate-500">{{
                            ucfirst($listing->transaction_type) }}</span>
                        @if (filled($listing->availability))
                        <span
                            class="rounded-full bg-amber-50 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-amber-700">{{
                            ucfirst($listing->availability) }}</span>
                        @endif
                    </div>

                    <div class="mt-8 flex flex-col justify-between gap-6 md:flex-row md:items-end">
                        <div>
                            <p class="text-sm font-medium text-slate-500">{{ $listing->area ? $listing->area.', ' : ''
                                }}{{
                                $listing->city }}, {{ $listing->country }}</p>
                            <p class="mt-2 text-4xl font-extrabold tracking-tight text-[var(--color-ink)]">{{
                                $listing->formattedPrimaryValue }}</p>
                        </div>
                        @if ($listing->is_verified)
                        <div class="flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-emerald-700">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-xs font-bold uppercase tracking-wider">Verified Seller</span>
                        </div>
                        @endif
                    </div>

                    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach (($listing->details ?? []) as $label => $value)
                        <div class="rounded-2xl bg-[var(--color-mist)] p-4">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-[var(--color-clay)]">{{
                                str_replace('_', ' ', $label) }}</p>
                            <p class="mt-2 text-base font-bold capitalize text-[var(--color-ink)]">{{ $value }}</p>
                        </div>
                        @endforeach
                    </div>

                    @if (filled($listing->highlights))
                    <div class="mt-8">
                        <h2 class="font-display text-2xl font-bold">Highlights</h2>
                        <div class="mt-4 flex flex-wrap gap-3">
                            @foreach ($listing->highlights as $highlight)
                            <span
                                class="rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700">{{
                                $highlight }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="mt-8">
                        <h2 class="font-display text-2xl font-bold">Description</h2>
                        <p class="mt-4 text-base leading-8 text-slate-700">{{ $listing->description }}</p>
                    </div>
                </div>
            </section>

            <aside class="space-y-6">
                <div
                    class="rounded-[2rem] bg-white p-6 text-[var(--color-ink)] shadow-[0_25px_70px_-35px_rgba(8,20,33,0.6)] md:p-8">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-[var(--color-clay)]">Contact seller
                    </p>
                    <h2 class="mt-2 font-display text-2xl font-bold">{{ $listing->contact_name ??
                        $listing->seller?->name }}</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ $listing->seller?->company_name ?? 'Independent
                        seller' }}</p>
                    <p class="mt-4 text-sm text-slate-500">Use WhatsApp for viewing requests, price confirmation, salary
                        clarifications, application follow-up, or tenancy questions before you commit.</p>
                    <a href="{{ $listing->whatsappUrl }}" target="_blank"
                        class="mt-6 inline-flex w-full items-center justify-center rounded-full bg-[var(--color-leaf)] px-5 py-3 text-sm font-bold uppercase tracking-[0.2em] text-white">Chat
                        on WhatsApp</a>

                    @auth
                    @php $isSaved = auth()->user()->savedListings->contains($listing->id); @endphp
                    <form method="POST" action="{{ route($isSaved ? 'saved.destroy' : 'saved.store', $listing) }}"
                        class="mt-4">
                        @csrf
                        @if ($isSaved) @method('DELETE') @endif
                        <button type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-bold uppercase tracking-[0.2em] text-slate-700 transition hover:bg-slate-50">
                            <svg class="h-5 w-5 {{ $isSaved ? 'fill-red-500 text-red-500' : 'fill-none text-slate-400' }}"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                            {{ $isSaved ? 'Remove from Saved' : 'Save to Favorites' }}
                        </button>
                    </form>
                    @endauth
                </div>

                <div
                    class="rounded-[2rem] bg-white p-6 text-[var(--color-ink)] shadow-[0_25px_70px_-35px_rgba(8,20,33,0.6)] md:p-8">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-[var(--color-clay)]">Seller tools
                    </p>
                    <h2 class="mt-2 font-display text-2xl font-bold">List and manage inventory through connectify</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Dealers, agents, recruiters and service providers
                        can manage listings, update availability, and keep enquiries flowing through dedicated seller
                        and admin panels.</p>
                    <div class="mt-6 space-y-3 text-sm text-slate-600">
                        <p>Seller panel for listing management and edits</p>
                        <p>Admin panel for moderation, approvals and marketplace oversight</p>
                    </div>
                </div>

                @if ($similarListings->isNotEmpty())
                <div
                    class="rounded-[2rem] bg-white p-6 text-[var(--color-ink)] shadow-[0_25px_70px_-35px_rgba(8,20,33,0.6)] md:p-8">
                    <h2 class="font-display text-2xl font-bold">Similar listings</h2>
                    <div class="mt-5 space-y-4">
                        @foreach ($similarListings as $similar)
                        <a href="{{ route('listings.show', $similar) }}"
                            class="flex gap-4 rounded-2xl border border-slate-200 p-3 transition hover:border-[var(--color-sun)]">
                            <img src="{{ $similar->cover_image }}" alt="{{ $similar->title }}"
                                class="h-20 w-20 rounded-2xl object-cover">
                            <div>
                                <p class="font-semibold">{{ $similar->title }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $similar->city }}, {{ $similar->country }}</p>
                                <p class="mt-2 text-sm font-bold">{{ $similar->formattedPrimaryValue }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </aside>
        </div>
    </main>
</x-layouts.app>
