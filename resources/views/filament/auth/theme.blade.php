<style>
    .fi-simple-layout {
        position: relative;
        min-height: 100dvh;
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
        padding: 2rem 1rem 3rem;
    }

    .fi-simple-main {
        border-radius: 2rem !important;
        border: 1px solid rgba(143, 208, 255, 0.22);
        background: linear-gradient(180deg, rgba(9, 23, 40, 0.96), rgba(6, 16, 30, 0.94)) !important;
        box-shadow: 0 40px 100px -48px rgba(0, 0, 0, 0.9);
        padding: 2rem 1.4rem !important;
        color: #d9e8f6;
    }

    @media (min-width: 640px) {
        .fi-simple-main {
            padding: 2.75rem !important;
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
    .fi-simple-main .fi-checkbox-label {
        color: #d3e3f5 !important;
        font-weight: 600;
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
        margin-bottom: 1.5rem;
        border-radius: 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: linear-gradient(180deg, rgba(17, 29, 46, 0.96), rgba(7, 17, 31, 0.95));
        padding: 1.25rem;
        color: white;
        box-shadow: 0 28px 70px -42px rgba(0, 0, 0, 0.75);
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
</style>
