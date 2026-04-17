<x-layouts.app :title="$listing->title.' | Connectify'">
    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 lg:py-12">
        <a href="{{ route('home') }}" class="inline-flex items-center rounded-full border border-white/15 bg-white/10 px-4 py-2 text-sm font-semibold text-white/85 backdrop-blur">Back to marketplace</a>

        <div class="mt-6 grid gap-8 lg:grid-cols-[1.25fr_0.75fr]">
            <section class="space-y-6">
                <div class="overflow-hidden rounded-[2rem] bg-white shadow-[0_25px_70px_-35px_rgba(8,20,33,0.6)]">
                    <img src="{{ $listing->cover_image }}" alt="{{ $listing->title }}" class="h-[22rem] w-full object-cover sm:h-[30rem]">
                    @if (filled($listing->gallery))
                        <div class="grid grid-cols-2 gap-3 p-4 md:grid-cols-3">
                            @foreach ($listing->gallery as $image)
                                <img src="{{ $image }}" alt="{{ $listing->title }} gallery image" class="h-32 w-full rounded-2xl object-cover">
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="rounded-[2rem] bg-white p-6 text-[var(--color-ink)] shadow-[0_25px_70px_-35px_rgba(8,20,33,0.6)] md:p-8">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="rounded-full bg-[var(--color-mist)] px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-[var(--color-clay)]">{{ $listing->type->label() }}</span>
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-slate-600">{{ ucfirst($listing->transaction_type) }}</span>
                        @if ($listing->is_verified)
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Verified seller</span>
                        @endif
                    </div>

                    <h1 class="mt-4 font-display text-3xl font-bold sm:text-5xl">{{ $listing->title }}</h1>
                    <p class="mt-3 text-base text-slate-600">{{ $listing->area ? $listing->area.', ' : '' }}{{ $listing->city }}, {{ $listing->country }}</p>
                    <p class="mt-4 text-3xl font-extrabold text-[var(--color-ink)]">{{ $listing->formattedPrimaryValue() }}</p>

                    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach (($listing->details ?? []) as $label => $value)
                            <div class="rounded-2xl bg-[var(--color-mist)] p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[var(--color-clay)]">{{ str_replace('_', ' ', $label) }}</p>
                                <p class="mt-2 text-base font-bold capitalize text-[var(--color-ink)]">{{ $value }}</p>
                            </div>
                        @endforeach
                    </div>

                    @if (filled($listing->highlights))
                        <div class="mt-8">
                            <h2 class="font-display text-2xl font-bold">Highlights</h2>
                            <div class="mt-4 flex flex-wrap gap-3">
                                @foreach ($listing->highlights as $highlight)
                                    <span class="rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700">{{ $highlight }}</span>
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
                <div class="rounded-[2rem] bg-white p-6 text-[var(--color-ink)] shadow-[0_25px_70px_-35px_rgba(8,20,33,0.6)] md:p-8">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[var(--color-clay)]">Contact seller</p>
                    <h2 class="mt-2 font-display text-2xl font-bold">{{ $listing->contact_name ?? $listing->seller?->name }}</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ $listing->seller?->company_name ?? 'Independent seller' }}</p>
                    <p class="mt-4 text-sm text-slate-500">Use WhatsApp for viewing requests, price confirmation, salary clarifications, application follow-up, or tenancy questions before you commit.</p>
                    <a href="{{ $listing->whatsappUrl() }}" target="_blank" class="mt-6 inline-flex w-full items-center justify-center rounded-full bg-[var(--color-leaf)] px-5 py-3 text-sm font-bold uppercase tracking-[0.2em] text-white">Chat on WhatsApp</a>
                </div>

                <div class="rounded-[2rem] bg-white p-6 text-[var(--color-ink)] shadow-[0_25px_70px_-35px_rgba(8,20,33,0.6)] md:p-8">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[var(--color-clay)]">Seller tools</p>
                    <h2 class="mt-2 font-display text-2xl font-bold">List and manage inventory through Connectify</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Dealers, agents, recruiters and service providers can manage listings, update availability, and keep enquiries flowing through dedicated seller and admin panels.</p>
                    <div class="mt-6 space-y-3 text-sm text-slate-600">
                        <p>Seller panel for listing management and edits</p>
                        <p>Admin panel for moderation, approvals and marketplace oversight</p>
                    </div>
                </div>

                @if ($similarListings->isNotEmpty())
                    <div class="rounded-[2rem] bg-white p-6 text-[var(--color-ink)] shadow-[0_25px_70px_-35px_rgba(8,20,33,0.6)] md:p-8">
                        <h2 class="font-display text-2xl font-bold">Similar listings</h2>
                        <div class="mt-5 space-y-4">
                            @foreach ($similarListings as $similar)
                                <a href="{{ route('listings.show', $similar) }}" class="flex gap-4 rounded-2xl border border-slate-200 p-3 transition hover:border-[var(--color-sun)]">
                                    <img src="{{ $similar->cover_image }}" alt="{{ $similar->title }}" class="h-20 w-20 rounded-2xl object-cover">
                                    <div>
                                        <p class="font-semibold">{{ $similar->title }}</p>
                                        <p class="mt-1 text-sm text-slate-500">{{ $similar->city }}, {{ $similar->country }}</p>
                                        <p class="mt-2 text-sm font-bold">{{ $similar->formattedPrimaryValue() }}</p>
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