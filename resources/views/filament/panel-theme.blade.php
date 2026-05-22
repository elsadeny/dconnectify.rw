<style>
    .fi-body.fi-panel-admin,
    .fi-body.fi-panel-seller {
        overflow: hidden;
        background:
            radial-gradient(circle at top left, rgba(29, 143, 255, 0.14), transparent 22%),
            radial-gradient(circle at top right, rgba(103, 184, 255, 0.08), transparent 18%),
            linear-gradient(180deg, #08111d 0%, #0d1826 48%, #101c2a 100%);
        color: #e5eef9;
    }

    .fi-body.fi-panel-admin .fi-layout,
    .fi-body.fi-panel-seller .fi-layout {
        height: 100dvh;
        overflow: hidden;
    }

    .fi-body.fi-panel-admin .fi-sidebar,
    .fi-body.fi-panel-seller .fi-sidebar {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        display: flex;
        flex-direction: column;
        min-height: 100dvh;
        height: 100dvh;
        width: var(--sidebar-width);
        background: linear-gradient(180deg, rgba(7, 17, 31, 0.98), rgba(12, 29, 48, 0.98));
        border-right: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: none;
    }

    .fi-body.fi-panel-admin .fi-sidebar-header,
    .fi-body.fi-panel-seller .fi-sidebar-header,
    .fi-body.fi-panel-admin .fi-sidebar-footer,
    .fi-body.fi-panel-seller .fi-sidebar-footer {
        background: transparent;
    }

    .fi-body.fi-panel-admin .fi-topbar,
    .fi-body.fi-panel-seller .fi-topbar {
        margin: 0;
        border: 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 0;
        background: linear-gradient(180deg, rgba(13, 27, 46, 0.92), rgba(10, 22, 37, 0.9));
        box-shadow: none;
        backdrop-filter: blur(18px);
    }

    .fi-body.fi-panel-admin .fi-topbar-ctn,
    .fi-body.fi-panel-seller .fi-topbar-ctn {
        position: fixed;
        top: 0;
        right: 0;
        left: var(--sidebar-width);
        z-index: 40;
    }

    .fi-body.fi-panel-admin .fi-main-ctn,
    .fi-body.fi-panel-seller .fi-main-ctn {
        margin-left: var(--sidebar-width);
        height: 100dvh;
        min-height: 100dvh;
        padding-top: 4.5rem;
        overflow: hidden;
    }

    .fi-body.fi-panel-admin .fi-topbar .fi-input-wrp,
    .fi-body.fi-panel-seller .fi-topbar .fi-input-wrp {
        border-color: rgba(255, 255, 255, 0.08);
        background: rgba(255, 255, 255, 0.06);
    }

    .fi-body.fi-panel-admin .fi-topbar input,
    .fi-body.fi-panel-seller .fi-topbar input,
    .fi-body.fi-panel-admin .fi-topbar .fi-input,
    .fi-body.fi-panel-seller .fi-topbar .fi-input,
    .fi-body.fi-panel-admin .fi-topbar .fi-icon-btn,
    .fi-body.fi-panel-seller .fi-topbar .fi-icon-btn {
        color: #ecf4ff;
    }

    .fi-body.fi-panel-admin .fi-main,
    .fi-body.fi-panel-seller .fi-main {
        height: 100%;
        overflow-y: auto;
        overflow-x: hidden;
        padding-top: 1.25rem;
        padding-bottom: 1.5rem;
    }

    .fi-body.fi-panel-admin .fi-sidebar-nav,
    .fi-body.fi-panel-seller .fi-sidebar-nav {
        flex: 1;
        height: 100%;
        overflow-y: auto;
        overflow-x: hidden;
        min-height: 0;
    }

    .fi-body.fi-panel-admin .fi-page,
    .fi-body.fi-panel-seller .fi-page {
        gap: 1.25rem;
    }

    .fi-body.fi-panel-admin .fi-header,
    .fi-body.fi-panel-seller .fi-header {
        padding: 0;
    }

    .fi-body.fi-panel-admin .fi-header-heading,
    .fi-body.fi-panel-seller .fi-header-heading {
        color: #f3f9ff;
        font-weight: 800;
        letter-spacing: -0.03em;
    }

    .fi-body.fi-panel-admin .fi-header-subheading,
    .fi-body.fi-panel-seller .fi-header-subheading {
        color: #8ea6bf;
    }

    .fi-body.fi-panel-admin .fi-section,
    .fi-body.fi-panel-seller .fi-section,
    .fi-body.fi-panel-admin .fi-ta-ctn,
    .fi-body.fi-panel-seller .fi-ta-ctn,
    .fi-body.fi-panel-admin .fi-wi-stats-overview-stat,
    .fi-body.fi-panel-seller .fi-wi-stats-overview-stat {
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 1.45rem;
        background: linear-gradient(180deg, rgba(14, 28, 45, 0.96), rgba(10, 21, 35, 0.94));
        box-shadow: 0 26px 60px -46px rgba(0, 0, 0, 0.42);
    }

    .fi-body.fi-panel-admin .fi-section-header,
    .fi-body.fi-panel-seller .fi-section-header {
        padding-bottom: 0.75rem;
    }

    .fi-body.fi-panel-admin .fi-section-header-heading,
    .fi-body.fi-panel-seller .fi-section-header-heading {
        color: #f3f9ff;
        font-weight: 700;
        letter-spacing: -0.02em;
    }

    .fi-body.fi-panel-admin .fi-section-header-description,
    .fi-body.fi-panel-seller .fi-section-header-description {
        color: #91a9c2;
    }

    .fi-body.fi-panel-admin .fi-wi-stats-overview-stat,
    .fi-body.fi-panel-seller .fi-wi-stats-overview-stat {
        overflow: hidden;
        position: relative;
        min-height: 11rem;
        padding: 1.35rem;
    }

    .fi-body.fi-panel-admin .fi-wi-stats-overview-stat::before,
    .fi-body.fi-panel-seller .fi-wi-stats-overview-stat::before {
        content: '';
        position: absolute;
        inset: 0 0 auto 0;
        height: 3px;
        background: linear-gradient(90deg, #1d8fff, #8fd0ff);
    }

    .fi-body.fi-panel-admin .fi-wi-stats-overview-stat-label,
    .fi-body.fi-panel-seller .fi-wi-stats-overview-stat-label {
        color: #9cb2c9;
        font-weight: 700;
        letter-spacing: 0.02em;
    }

    .fi-body.fi-panel-admin .fi-wi-stats-overview-stat-value,
    .fi-body.fi-panel-seller .fi-wi-stats-overview-stat-value {
        color: #f3f9ff;
        font-size: clamp(1.8rem, 2vw, 2.5rem);
        font-weight: 800;
        letter-spacing: -0.04em;
    }

    .fi-body.fi-panel-admin .fi-wi-stats-overview-stat-description,
    .fi-body.fi-panel-seller .fi-wi-stats-overview-stat-description {
        color: #8ea6bf;
    }

    .fi-body.fi-panel-admin .fi-sidebar-item-btn,
    .fi-body.fi-panel-seller .fi-sidebar-item-btn,
    .fi-body.fi-panel-admin .fi-sidebar-group-btn,
    .fi-body.fi-panel-seller .fi-sidebar-group-btn {
        border-radius: 0.85rem;
    }

    .fi-body.fi-panel-admin .fi-sidebar-item.fi-active .fi-sidebar-item-btn,
    .fi-body.fi-panel-seller .fi-sidebar-item.fi-active .fi-sidebar-item-btn {
        background: linear-gradient(135deg, rgba(29, 143, 255, 0.18), rgba(143, 208, 255, 0.14));
        box-shadow: inset 0 0 0 1px rgba(143, 208, 255, 0.18);
    }

    .fi-body.fi-panel-admin .fi-sidebar-item-label,
    .fi-body.fi-panel-seller .fi-sidebar-item-label,
    .fi-body.fi-panel-admin .fi-sidebar-group-label,
    .fi-body.fi-panel-seller .fi-sidebar-group-label {
        color: rgba(236, 244, 255, 0.92);
    }

    .fi-body.fi-panel-admin .fi-sidebar-item-icon,
    .fi-body.fi-panel-seller .fi-sidebar-item-icon {
        color: #8fd0ff;
    }

    .fi-body.fi-panel-admin .fi-ta-header-cell-label,
    .fi-body.fi-panel-seller .fi-ta-header-cell-label {
        color: #89a1b9;
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    .fi-body.fi-panel-admin .fi-ta-text,
    .fi-body.fi-panel-seller .fi-ta-text,
    .fi-body.fi-panel-admin .fi-ta-record,
    .fi-body.fi-panel-seller .fi-ta-record,
    .fi-body.fi-panel-admin .fi-pagination,
    .fi-body.fi-panel-seller .fi-pagination {
        color: #d9e6f4;
    }

    .fi-body.fi-panel-admin .fi-badge,
    .fi-body.fi-panel-seller .fi-badge {
        border-color: rgba(255, 255, 255, 0.08);
    }

    .fi-body.fi-panel-admin .fi-btn,
    .fi-body.fi-panel-seller .fi-btn {
        border-radius: 9999px;
    }

    .fi-body.fi-panel-admin .fi-btn-color-primary,
    .fi-body.fi-panel-seller .fi-btn-color-primary {
        background: linear-gradient(135deg, #1d8fff, #8fd0ff);
        color: #07111f;
        box-shadow: 0 18px 36px -24px rgba(29, 143, 255, 0.75);
    }

    .connectify-panel-hero {
        display: grid;
        gap: 1.25rem;
        grid-template-columns: minmax(0, 1.35fr) minmax(0, 1fr);
        border: 1px solid rgba(183, 204, 225, 0.72);
        border-radius: 1.85rem;
        padding: 1.6rem;
        background:
            radial-gradient(circle at top left, rgba(143, 208, 255, 0.22), transparent 34%),
            linear-gradient(145deg, rgba(8, 20, 34, 0.98), rgba(15, 39, 61, 0.96));
        box-shadow: 0 40px 90px -54px rgba(7, 17, 31, 0.72);
    }

    .connectify-panel-hero__content {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 1rem;
    }

    .connectify-panel-hero__eyebrow {
        margin: 0;
        color: #9fcbf5;
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.2em;
        text-transform: uppercase;
    }

    .connectify-panel-hero__title {
        margin: 0;
        color: #f3f9ff;
        font-size: clamp(1.9rem, 2.5vw, 3rem);
        line-height: 1.05;
        font-weight: 800;
        letter-spacing: -0.04em;
    }

    .connectify-panel-hero__copy {
        margin: 0;
        max-width: 46rem;
        color: rgba(236, 244, 255, 0.7);
        font-size: 0.98rem;
        line-height: 1.7;
    }

    .connectify-panel-hero__actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .connectify-panel-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 2.9rem;
        padding: 0 1.1rem;
        border-radius: 9999px;
        font-size: 0.82rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-decoration: none;
        text-transform: uppercase;
        transition: transform 0.2s ease, opacity 0.2s ease;
    }

    .connectify-panel-btn:hover {
        transform: translateY(-1px);
    }

    .connectify-panel-btn-primary {
        background: linear-gradient(135deg, #1d8fff, #8fd0ff);
        color: #07111f;
    }

    .connectify-panel-btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #f3f9ff;
    }

    .connectify-panel-btn-ghost {
        color: rgba(243, 249, 255, 0.86);
    }

    .connectify-panel-hero__grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.9rem;
    }

    .connectify-panel-kpi {
        border: 1px solid rgba(255, 255, 255, 0.09);
        border-radius: 1.35rem;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(12px);
    }

    .connectify-panel-kpi__label {
        display: block;
        color: rgba(243, 249, 255, 0.62);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .connectify-panel-kpi__value {
        display: block;
        margin-top: 0.55rem;
        color: #f3f9ff;
        font-size: 1.75rem;
        font-weight: 800;
        letter-spacing: -0.03em;
    }

    .connectify-dashboard-grid {
        display: grid;
        gap: 1rem;
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .connectify-dashboard-card {
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 1.45rem;
        padding: 1.3rem;
        background: linear-gradient(180deg, rgba(14, 28, 45, 0.96), rgba(10, 21, 35, 0.94));
        box-shadow: 0 24px 50px -42px rgba(0, 0, 0, 0.42);
    }

    .connectify-dashboard-card__header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .connectify-dashboard-card__eyebrow {
        margin: 0;
        color: #8eaecb;
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.18em;
        text-transform: uppercase;
    }

    .connectify-dashboard-card__title {
        margin: 0.35rem 0 0;
        color: #f3f9ff;
        font-size: 1.2rem;
        font-weight: 800;
        letter-spacing: -0.03em;
    }

    .connectify-inline-link {
        color: #8fd0ff;
        font-size: 0.82rem;
        font-weight: 700;
        text-decoration: none;
    }

    .connectify-dashboard-metric-list {
        display: grid;
        gap: 0.75rem;
    }

    .connectify-dashboard-metric {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        border-radius: 1rem;
        padding: 0.9rem 1rem;
        background: rgba(255, 255, 255, 0.05);
    }

    .connectify-dashboard-metric span {
        color: #9bb2c8;
        font-weight: 600;
    }

    .connectify-dashboard-metric strong {
        color: #f3f9ff;
        font-size: 1.05rem;
        font-weight: 800;
    }

    .connectify-dashboard-note {
        margin-top: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        padding-top: 1rem;
        color: #8ea6bf;
        font-size: 0.9rem;
        line-height: 1.7;
    }

    .connectify-dashboard-note p {
        margin: 0;
    }

    @media (max-width: 1024px) {
        .connectify-panel-hero,
        .connectify-dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .fi-body.fi-panel-admin,
        .fi-body.fi-panel-seller,
        .fi-body.fi-panel-admin .fi-layout,
        .fi-body.fi-panel-seller .fi-layout {
            overflow: visible;
        }

        .fi-body.fi-panel-admin .fi-sidebar,
        .fi-body.fi-panel-seller .fi-sidebar {
            width: auto;
            min-height: 100dvh;
            height: 100dvh;
        }

        .fi-body.fi-panel-admin .fi-topbar-ctn,
        .fi-body.fi-panel-seller .fi-topbar-ctn {
            position: sticky;
            left: 0;
        }

        .fi-body.fi-panel-admin .fi-main-ctn,
        .fi-body.fi-panel-seller .fi-main-ctn {
            height: auto;
            margin-left: 0;
            padding-top: 4rem;
            overflow: visible;
        }

        .fi-body.fi-panel-admin .fi-topbar,
        .fi-body.fi-panel-seller .fi-topbar {
            margin: 0;
            border-radius: 0;
        }

        .fi-body.fi-panel-admin .fi-main,
        .fi-body.fi-panel-seller .fi-main,
        .fi-body.fi-panel-admin .fi-sidebar-nav,
        .fi-body.fi-panel-seller .fi-sidebar-nav {
            height: auto;
            overflow: visible;
        }

        .fi-body.fi-panel-admin .fi-sidebar-nav,
        .fi-body.fi-panel-seller .fi-sidebar-nav {
            min-height: calc(100dvh - 4rem);
            overflow-y: auto;
        }

        .connectify-panel-hero {
            padding: 1.2rem;
        }

        .connectify-panel-hero__grid {
            grid-template-columns: 1fr;
        }
    }
</style>
