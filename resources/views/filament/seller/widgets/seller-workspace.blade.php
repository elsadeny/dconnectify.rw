<x-filament-widgets::widget>
    <div class="connectify-dashboard-grid">
        <section class="connectify-dashboard-card">
            <div class="connectify-dashboard-card__header">
                <div>
                    <p class="connectify-dashboard-card__eyebrow">Listing flow</p>
                    <h3 class="connectify-dashboard-card__title">What needs attention now</h3>
                </div>
                <a href="/seller/listings" class="connectify-inline-link">Manage inventory</a>
            </div>

            <div class="connectify-dashboard-metric-list">
                @foreach ($listingStates as $item)
                    <div class="connectify-dashboard-metric">
                        <span>{{ $item['label'] }}</span>
                        <strong>{{ number_format($item['count']) }}</strong>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="connectify-dashboard-card">
            <div class="connectify-dashboard-card__header">
                <div>
                    <p class="connectify-dashboard-card__eyebrow">Conversion</p>
                    <h3 class="connectify-dashboard-card__title">Booking visibility</h3>
                </div>
                <a href="/seller/bookings" class="connectify-inline-link">Open bookings</a>
            </div>

            <div class="connectify-dashboard-metric-list">
                @foreach ($bookingStats as $item)
                    <div class="connectify-dashboard-metric">
                        <span>{{ $item['label'] }}</span>
                        <strong>{{ number_format($item['count']) }}</strong>
                    </div>
                @endforeach
            </div>

            <div class="connectify-dashboard-note">
                <p>Keep cover images, price, and WhatsApp details current before pushing listings live.</p>
            </div>
        </section>
    </div>
</x-filament-widgets::widget>
