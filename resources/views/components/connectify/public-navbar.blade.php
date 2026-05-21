@props([
    'ctaHref' => '/seller/login',
    'ctaLabel' => 'Seller Panel',
    'homeHref' => null,
    'showSectionLinks' => true,
    'fixed' => true,
])

@php
    $homeHref ??= route('home');
    $sectionBase = rtrim($homeHref, '/');
@endphp

<header @class([
    'connectify-public-navbar',
    'connectify-public-navbar--fixed' => $fixed,
])>
    <div class="mx-auto max-w-7xl">
        <div class="connectify-public-navbar__shell">
            <a href="{{ $homeHref }}" class="connectify-public-navbar__brand">
                <div class="connectify-public-navbar__logo">
                    C
                </div>
                <div class="connectify-public-navbar__copy">
                    <p class="connectify-public-navbar__name">connectify</p>
                    <p class="connectify-public-navbar__tag connectify-public-navbar__tag--desktop">Premium marketplace across East Africa</p>
                    <p class="connectify-public-navbar__tag connectify-public-navbar__tag--mobile">East Africa Marketplace</p>
                </div>
            </a>

            <nav class="connectify-public-navbar__nav">
                @if ($showSectionLinks)
                    <a href="{{ $sectionBase }}#categories" class="connectify-public-navbar__link">Categories</a>
                    <a href="{{ $sectionBase }}#why-connectify" class="connectify-public-navbar__link">Why connectify</a>
                    <a href="{{ $sectionBase }}#featured" class="connectify-public-navbar__link">Featured</a>
                    <a href="{{ $sectionBase }}#latest" class="connectify-public-navbar__link">Latest</a>
                @endif

                <a href="{{ $ctaHref }}" class="connectify-public-navbar__cta">
                    {{ $ctaLabel }}
                </a>
            </nav>
        </div>
    </div>
</header>
