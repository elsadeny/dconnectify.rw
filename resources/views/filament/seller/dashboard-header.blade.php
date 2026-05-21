<section class="connectify-panel-hero connectify-panel-hero-seller">
    <div class="connectify-panel-hero__content">
        <p class="connectify-panel-hero__eyebrow">Seller workspace</p>
        <h1 class="connectify-panel-hero__title">Run listings like inventory, not like posts.</h1>
        <p class="connectify-panel-hero__copy">
            Keep your active stock visible, your draft queue short, and your bookings easy to follow from one calm workspace.
        </p>

        <div class="connectify-panel-hero__actions">
            <a href="/seller/listings/create" class="connectify-panel-btn connectify-panel-btn-primary">Create listing</a>
            <a href="/seller/listings" class="connectify-panel-btn connectify-panel-btn-secondary">Manage listings</a>
            <a href="/seller/bookings" class="connectify-panel-btn connectify-panel-btn-ghost">Open bookings</a>
        </div>
    </div>

    <div class="connectify-panel-hero__grid">
        <div class="connectify-panel-kpi">
            <span class="connectify-panel-kpi__label">Listings</span>
            <strong class="connectify-panel-kpi__value">{{ number_format($stats['listings']) }}</strong>
        </div>
        <div class="connectify-panel-kpi">
            <span class="connectify-panel-kpi__label">Published</span>
            <strong class="connectify-panel-kpi__value">{{ number_format($stats['published']) }}</strong>
        </div>
        <div class="connectify-panel-kpi">
            <span class="connectify-panel-kpi__label">Draft or pending</span>
            <strong class="connectify-panel-kpi__value">{{ number_format($stats['pending']) }}</strong>
        </div>
        <div class="connectify-panel-kpi">
            <span class="connectify-panel-kpi__label">Bookings</span>
            <strong class="connectify-panel-kpi__value">{{ number_format($stats['bookings']) }}</strong>
        </div>
    </div>
</section>
