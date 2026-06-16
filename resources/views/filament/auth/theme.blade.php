<style>
    html,
    body {
        height: 100%;
    }

    .fi-simple-layout {
        position: relative;
        height: 100dvh;
        display: flex;
        flex-direction: column;
        background:
            radial-gradient(circle at 12% 12%, rgba(29, 143, 255, 0.24), transparent 22%),
            radial-gradient(circle at 88% 10%, rgba(103, 184, 255, 0.18), transparent 20%),
            linear-gradient(180deg, #040914 0%, #0d1b2e 34%, #16314f 100%);
        overflow: hidden;
    }

    .fi-simple-layout::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
        background-size: 72px 72px;
        mask-image: linear-gradient(180deg, black 0%, black 55%, transparent 100%);
        pointer-events: none;
    }

    .fi-simple-main-ctn {
        position: relative;
        z-index: 1;
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 0;
        padding: 6.75rem 1rem 4.5rem;
    }

    .fi-simple-main {
        width: 100%;
        max-height: calc(100dvh - 11.25rem);
        overflow: auto;
        border-radius: 2rem !important;
        border: 1px solid rgba(143, 208, 255, 0.22);
        background: linear-gradient(180deg, rgba(9, 23, 40, 0.96), rgba(6, 16, 30, 0.94)) !important;
        box-shadow: 0 40px 100px -48px rgba(0, 0, 0, 0.9);
        padding: 1.6rem 1.35rem !important;
        color: #d9e8f6;
        scrollbar-width: thin;
        scrollbar-color: rgba(143, 208, 255, 0.35) transparent;
    }

    @media (min-width: 640px) {
        .fi-simple-main {
            padding: 2.15rem !important;
        }
    }

    .fi-simple-main .fi-logo {
        color: #ecf4ff !important;
        font-weight: 800;
        letter-spacing: -0.03em;
    }

    .fi-simple-main [class*="fi-simple-header-heading"],
    .fi-simple-main [class*="fi-simple-header-subheading"],
    .fi-simple-main h1,
    .fi-simple-main h2,
    .fi-simple-main h3 {
        color: #ecf4ff !important;
    }

    .fi-simple-main [class*="fi-input-wrp-label"],
    .fi-simple-main label,
    .fi-simple-main .fi-checkbox-label,
    .fi-simple-main [class*="fi-fo-field-wrp-label"],
    .fi-simple-main [class*="fi-fo-field-wrp-label"] *,
    .fi-simple-main label *,
    .fi-simple-main legend {
        color: #d3e3f5 !important;
        font-weight: 600;
    }

    .fi-simple-main [class*="fi-fo-field-wrp-required-mark"] {
        color: #ff6b6b !important;
    }

    .fi-simple-main [class*="fi-fo-field-wrp-hint"],
    .fi-simple-main [class*="fi-fo-field-wrp-helper-text"] {
        color: #9bb4cf !important;
    }

    .fi-simple-main .fi-input-wrp {
        border-radius: 1rem;
        border-color: rgba(143, 208, 255, 0.28);
        background: rgba(18, 39, 62, 0.9);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.03);
    }

    .fi-simple-main .fi-input,
    .fi-simple-main input,
    .fi-simple-main select,
    .fi-simple-main textarea {
        color: #ecf4ff !important;
    }

    .fi-simple-main .fi-input::placeholder,
    .fi-simple-main input::placeholder,
    .fi-simple-main textarea::placeholder {
        color: #8ea6bf !important;
        opacity: 1;
    }

    .fi-simple-main .fi-input-wrp:focus-within {
        border-color: #1d8fff;
        box-shadow: 0 0 0 4px rgba(29, 143, 255, 0.14);
    }

    .fi-simple-main .fi-btn.fi-color-primary {
        border-radius: 9999px;
        background: linear-gradient(135deg, #1d8fff, #8fd0ff) !important;
        color: #07111f !important;
        box-shadow: 0 22px 40px -22px rgba(29, 143, 255, 0.8);
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .fi-simple-main .fi-btn.fi-outlined {
        border-radius: 9999px;
    }

    .fi-simple-main .fi-link,
    .fi-simple-main a {
        color: #7ec4ff;
    }

    .fi-simple-main .fi-link:hover,
    .fi-simple-main a:hover {
        color: #b9e1ff;
    }

    .fi-simple-main [type='checkbox'] {
        border-color: rgba(143, 208, 255, 0.42);
        background-color: rgba(13, 31, 49, 0.92);
    }

    .fi-simple-main [type='checkbox']:checked {
        border-color: #1d8fff;
        background-color: #1d8fff;
    }

    .connectify-auth-intro {
        margin-bottom: 1rem;
        border-radius: 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: linear-gradient(180deg, rgba(17, 29, 46, 0.96), rgba(7, 17, 31, 0.95));
        padding: 1rem;
        color: white;
        box-shadow: 0 28px 70px -42px rgba(0, 0, 0, 0.75);
    }

    .connectify-public-navbar {
        inset-inline: 0;
        z-index: 50;
        padding: 1rem 1rem 0;
        pointer-events: auto;
    }

    .connectify-public-navbar--fixed {
        position: fixed;
        top: 0;
    }

    .connectify-public-navbar__shell {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        max-width: 80rem;
        margin: 0 auto;
        padding: 0.75rem 1rem;
        border-radius: 9999px;
        background: linear-gradient(180deg, rgba(7, 17, 31, 0.92), rgba(4, 9, 20, 0.88));
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 24px 80px -40px rgba(0, 0, 0, 0.55);
        backdrop-filter: blur(24px);
    }

    .connectify-public-navbar__brand {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        min-width: 0;
        text-decoration: none;
    }

    .connectify-public-navbar__logo {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.75rem;
        height: 2.75rem;
        border-radius: 9999px;
        background: linear-gradient(135deg, #1d8fff, #8fd0ff);
        color: #07111f;
        font-size: 1.125rem;
        font-weight: 900;
        flex-shrink: 0;
    }

    .connectify-public-navbar__copy {
        min-width: 0;
    }

    .connectify-public-navbar__name {
        margin: 0;
        color: #ffffff;
        font-size: 1.125rem;
        font-weight: 800;
        line-height: 1.1;
    }

    .connectify-public-navbar__tag {
        margin-top: 0.18rem;
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.625rem;
        font-weight: 600;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        line-height: 1.2;
    }

    .connectify-public-navbar__tag--mobile {
        display: none;
    }

    .connectify-public-navbar__nav {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .connectify-public-navbar__link {
        color: rgba(255, 255, 255, 0.8) !important;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.2s ease, opacity 0.2s ease;
    }

    .connectify-public-navbar__link:hover {
        color: #ffffff !important;
    }

    .connectify-public-navbar__cta {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 2.5rem;
        padding: 0 1rem;
        border-radius: 9999px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        background: rgba(255, 255, 255, 0.95);
        color: #07111f !important;
        font-size: 0.875rem;
        font-weight: 700;
        text-decoration: none;
        transition: transform 0.2s ease;
    }

    .connectify-public-navbar__cta:hover {
        transform: translateY(-1px);
    }

    .connectify-auth-intro__eyebrow {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        color: #9fcbf5;
    }

    .connectify-auth-intro__title {
        margin-top: 0.7rem;
        font-size: 1.5rem;
        line-height: 1.15;
        font-weight: 800;
        letter-spacing: -0.03em;
    }

    .connectify-auth-intro__copy {
        margin-top: 0.7rem;
        font-size: 0.92rem;
        line-height: 1.65;
        color: rgba(255, 255, 255, 0.72);
    }

    .connectify-auth-intro__chips {
        display: flex;
        flex-wrap: wrap;
        gap: 0.55rem;
        margin-top: 1rem;
    }

    .connectify-auth-intro__chip {
        border-radius: 9999px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(255, 255, 255, 0.08);
        padding: 0.45rem 0.8rem;
        font-size: 0.72rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.86);
    }

    .connectify-auth-footer {
        position: fixed;
        inset-inline: 0;
        bottom: 0;
        z-index: 2;
        padding: 0.6rem 1rem 0.95rem;
        text-align: center;
        pointer-events: none;
    }

    .connectify-auth-footer p {
        margin: 0;
        color: rgba(255, 255, 255, 0.54);
        font-size: 0.76rem;
        line-height: 1.6;
    }

    @media (max-width: 640px) {
        body {
            overflow-y: auto;
        }

        .fi-simple-layout {
            height: auto;
            min-height: 100dvh;
        }

        .fi-simple-main-ctn {
            align-items: start;
            padding-top: 6.4rem;
            padding-bottom: 4rem;
        }

        .connectify-public-navbar__tag--desktop {
            display: none;
        }

        .connectify-public-navbar__tag--mobile {
            display: block;
        }

        .connectify-public-navbar__nav {
            display: none;
        }

        .fi-simple-main {
            max-height: none;
            overflow: visible;
            border-radius: 1.6rem !important;
            padding: 1.3rem 1.05rem !important;
        }

        .connectify-auth-intro {
            padding: 0.9rem;
        }

        .connectify-auth-footer {
            position: relative;
            inset: auto;
            padding-bottom: 1.15rem;
        }
    }
</style>
