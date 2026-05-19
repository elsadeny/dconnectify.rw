<x-layouts.app :title="'Saved Ads | connectify'">
    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 lg:py-12">
        <a href="{{ route('home') }}"
            class="inline-flex items-center rounded-full border border-white/15 bg-white/10 px-4 py-2 text-sm font-semibold text-white/85 backdrop-blur transition hover:bg-white/20">Back
            to marketplace</a>

        <div
            class="mt-8 surface-card rounded-[2rem] p-6 text-[var(--color-ink)] md:p-8 shadow-[0_25px_70px_-35px_rgba(8,20,33,0.6)]">
            <div class="flex flex-col gap-3 border-b border-slate-200 pb-6 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="section-heading">My Profile</p>
                    <h1 class="mt-2 font-display text-3xl font-bold">Saved Ads</h1>
                    <p class="mt-2 max-w-xl text-sm leading-6 text-slate-600">Your personal wishlist of cars, homes,
                        jobs, and services you are keeping an eye on.</p>
                </div>
            </div>

            <div class="mt-6 grid gap-4 lg:grid-cols-3">
                @forelse ($listings as $listing)
                <article
                    class="surface-card-soft rounded-[1.5rem] p-4 transition hover:-translate-y-1 hover:border-[var(--color-ocean)] hover:shadow-lg relative group">
                    <form method="POST" action="{{ route('saved.destroy', $listing) }}"
                        class="absolute top-6 right-6 z-20 hidden md:group-hover:block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="rounded-full bg-white/90 p-2 shadow backdrop-blur transition hover:scale-105"
                            title="Unsave">
                            <svg class="h-5 w-5 fill-red-500 text-red-500" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                        </button>
                    </form>
                    <img src="{{ $listing->cover_image }}" alt="{{ $listing->title }}"
                        class="h-48 w-full rounded-[1.25rem] object-cover">
                    <div class="mt-4 flex items-center justify-between gap-3">
                        <span
                            class="rounded-full bg-[var(--color-mist)] px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-[var(--color-clay)]">{{
                            $listing->type->label() }}</span>
                        <span class="text-xs text-slate-500">{{ $listing->area ?? $listing->city }}</span>
                    </div>
                    <h3 class="mt-3 font-display text-xl font-bold"><a href="{{ route('listings.show', $listing) }}">{{
                            $listing->title }}</a></h3>
                    <p class="mt-2 text-sm text-slate-500">{{ $listing->city }}, {{ $listing->country }}</p>
                    <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="text-lg font-extrabold">{{ $listing->formattedPrimaryValue }}</p>
                        </div>
                        <a href="{{ route('listings.show', $listing) }}"
                            class="rounded-full border border-[var(--color-sand)] bg-white/70 px-4 py-2 text-sm font-semibold shadow-[0_12px_24px_-18px_rgba(8,20,33,0.4)] transition hover:bg-slate-50">View
                            details</a>
                    </div>
                </article>
                @empty
                <div class="lg:col-span-3">
                    <div
                        class="surface-card-soft rounded-[1.5rem] border-dashed border-slate-300 px-6 py-12 text-center bg-slate-50">
                        <h3 class="font-display text-2xl font-bold">Your wishlist is empty</h3>
                        <p class="mt-2 text-sm text-slate-600">Browse the marketplace and click the heart icon on any
                            listing to save it here for later.</p>
                        <a href="{{ route('home') }}"
                            class="mt-6 inline-flex rounded-full bg-[var(--color-ink)] px-5 py-3 text-sm font-bold text-white transition hover:-translate-y-0.5">Explore
                            marketplace</a>
                    </div>
                </div>
                @endforelse
            </div>

            <div class="mt-6">{{ $listings->links() }}</div>
        </div>
    </main>
</x-layouts.app>