<x-filament-widgets::widget>
    <div class="connectify-dashboard-grid">
        <section class="connectify-dashboard-card">
            <div class="connectify-dashboard-card__header">
                <div>
                    <p class="connectify-dashboard-card__eyebrow">Inventory mix</p>
                    <h3 class="connectify-dashboard-card__title">Category coverage</h3>
                </div>
                <a href="/admin/listings" class="connectify-inline-link">Open listings</a>
            </div>

            <div class="connectify-dashboard-metric-list">
                @foreach ($typeCounts as $item)
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
                    <p class="connectify-dashboard-card__eyebrow">Ops health</p>
                    <h3 class="connectify-dashboard-card__title">Moderation and trust</h3>
                </div>
                <a href="/admin/users" class="connectify-inline-link">Seller oversight</a>
            </div>

            <div class="connectify-dashboard-metric-list">
                @foreach ($statusCounts as $item)
                    <div class="connectify-dashboard-metric">
                        <span>{{ $item['label'] }}</span>
                        <strong>{{ number_format($item['count']) }}</strong>
                    </div>
                @endforeach
            </div>

            <div class="connectify-dashboard-note">
                <p>Verified sellers: <strong>{{ number_format($sellerStats[0]['count']) }}</strong></p>
                <p>Buyer accounts: <strong>{{ number_format($sellerStats[1]['count']) }}</strong></p>
            </div>
        </section>
    </div>
</x-filament-widgets::widget>
