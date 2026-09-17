@if($profile->about_visible)
<section id="about" class="landing-about">
    <div class="landing-container">
        <p class="hero-eyebrow">01 / THE PERSON BEHIND THE WORK</p>
        <h2 class="section-heading">ABOUT ME.<span class="underline-stroke"></span></h2>
        <div class="about-grid">
            <article class="about-story nb-card">
                <div class="about-identity">
                    @if($profile->photoUrl('about'))<img class="about-portrait" src="{{ $profile->photoUrl('about') }}" alt="{{ $profile->about_photo_alt ?: $profile->about_name }}" width="320" height="320" loading="lazy">@endif
                    <div><h3>{{ $profile->about_name }}</h3>@if($profile->about_role)<p class="about-role">{{ $profile->about_role }}</p>@endif</div>
                </div>
                @if($profile->about_description)<p class="about-description">{{ $profile->about_description }}</p>@endif
            </article>
            <div class="about-facts">
                <div class="about-stat nb-card accent-red"><strong>{{ $profile->years_experience }}<span>+</span></strong><span>Years<br>Experience</span></div>
                <div class="about-stat nb-card accent-teal"><strong>{{ $profile->projects_completed }}<span>+</span></strong><span>Projects<br>Done</span></div>
                <div class="about-stat nb-card accent-lime"><strong>{{ $profile->happy_clients }}<span>+</span></strong><span>Happy<br>Clients</span></div>
                @if($profile->quote)<blockquote class="about-quote nb-card"><span aria-hidden="true">“</span><p>{{ $profile->quote }}</p></blockquote>@endif
            </div>
        </div>
    </div>
</section>
@endif
