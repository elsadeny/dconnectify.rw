<div class="connectify-auth-intro">
    <p class="connectify-auth-intro__eyebrow">{{ $eyebrow }}</p>
    <h2 class="connectify-auth-intro__title">{{ $title }}</h2>
    <p class="connectify-auth-intro__copy">{{ $copy }}</p>
    <div class="connectify-auth-intro__chips">
        @foreach ($chips as $chip)
            <span class="connectify-auth-intro__chip">{{ $chip }}</span>
        @endforeach
    </div>
</div>
