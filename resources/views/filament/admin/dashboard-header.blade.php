<section class="connectify-panel-hero connectify-panel-hero-admin">
    <div class="connectify-panel-hero__content">
        <p class="connectify-panel-hero__eyebrow">Control center</p>
        <h1 class="connectify-panel-hero__title">Keep the marketplace clean, trusted, and moving.</h1>
        <p class="connectify-panel-hero__copy">
            Review inventory, watch seller quality, and resolve bottlenecks before they spill into the buyer experience.
        </p>

        <div class="connectify-panel-hero__actions">
            <a href="/admin/listings" class="connectify-panel-btn connectify-panel-btn-primary">Review listings</a>
            <a href="/admin/users" class="connectify-panel-btn connectify-panel-btn-secondary">Manage users</a>
            <a href="/admin/bookings" class="connectify-panel-btn connectify-panel-btn-ghost">View bookings</a>
        </div>
    </div>

    <div class="connectify-panel-hero__grid">
        <div class="connectify-panel-kpi">
            <span class="connectify-panel-kpi__label">Total listings</span>
            <strong class="connectify-panel-kpi__value">{{ number_format($stats['listings']) }}</strong>
        </div>
        <div class="connectify-panel-kpi">
            <span class="connectify-panel-kpi__label">Pending review</span>
            <strong class="connectify-panel-kpi__value">{{ number_format($stats['pending']) }}</strong>
        </div>
        <div class="connectify-panel-kpi">
            <span class="connectify-panel-kpi__label">Seller accounts</span>
            <strong class="connectify-panel-kpi__value">{{ number_format($stats['sellers']) }}</strong>
        </div>
        <div class="connectify-panel-kpi">
            <span class="connectify-panel-kpi__label">Bookings logged</span>
            <strong class="connectify-panel-kpi__value">{{ number_format($stats['bookings']) }}</strong>
        </div>
    </div>
</section>
