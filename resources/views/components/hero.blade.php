@if($profile->hero_visible)
<section id="hero" class="landing-hero">
    <div class="hero-grid">
        <div class="hero-copy">
            <p class="hero-eyebrow"><span aria-hidden="true">✳</span> PERSONAL PORTFOLIO</p>
            <h1 class="hero-name">{{ $profile->hero_name }}</h1>
            @if($profile->hero_roles)
                <p class="hero-role"><span class="sr-only">{{ implode(', ', $profile->hero_roles) }}</span><span id="hero-typewriter" aria-hidden="true" data-roles="{{ json_encode($profile->hero_roles) }}">{{ $profile->hero_roles[0] }}</span><span class="typewriter-cursor" aria-hidden="true">|</span></p>
            @endif
            @if($profile->hero_description)<p class="hero-description">{{ $profile->hero_description }}</p>@endif
            <div class="hero-cta">
                @if($profile->cv_url && $profile->cv_label)<a href="{{ $profile->cv_url }}" target="_blank" rel="noopener noreferrer" class="nb-btn nb-btn-yellow">{{ $profile->cv_label }} <span aria-hidden="true">↗</span></a>@endif
                @if($profile->portfolio_url && $profile->portfolio_label)<a href="{{ $profile->portfolio_url }}" target="_blank" rel="noopener noreferrer" class="nb-btn nb-btn-dark">{{ $profile->portfolio_label }} <span aria-hidden="true">↗</span></a>@endif
            </div>
        </div>
        <div class="hero-portrait portrait-{{ $profile->hero_photo_style }}">
            <div class="portrait-grid" aria-hidden="true"></div>
            <div class="portrait-orbit" aria-hidden="true"></div>
            <span class="portrait-star" aria-hidden="true">✳</span>
            <div class="portrait-frame">
                @if($profile->photoUrl('hero'))
                    <img src="{{ $profile->photoUrl('hero') }}" alt="{{ $profile->hero_photo_alt ?: $profile->hero_name }}" width="600" height="750" fetchpriority="high">
                @else
                    <div class="portrait-placeholder"><span aria-hidden="true">MR.</span><span>YOUR NEXT CHAPTER.</span></div>
                @endif
            </div>
            <span class="portrait-caption" aria-hidden="true">DESIGN × CODE × IDEAS</span>
            <span class="portrait-dot" aria-hidden="true"></span>
        </div>
    </div>
</section>
@endif
