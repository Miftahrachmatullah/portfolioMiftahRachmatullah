<section id="skills" class="landing-skills">
    <div class="landing-container">
        <p class="hero-eyebrow">02 / MY EVERYDAY TOOLKIT</p>
        <h2 class="section-heading">SKILLS &amp; TOOLS.<span class="underline-stroke"></span></h2>
        <div class="landing-skills-grid">
            @forelse($skillGroups as $group)
                <article class="skill-group skill-accent-{{ $group->accent }}">
                    <h3>{{ $group->name }}</h3>
                    <div class="skill-items">@forelse($group->skills as $skill)<div class="skill-badge">@if($skill->icon_url)<img src="{{ $skill->icon_url }}" alt="" width="28" height="28" loading="lazy" data-skill-icon>@else<span class="skill-initial" aria-hidden="true">{{ Str::upper(Str::substr($skill->name, 0, 1)) }}</span>@endif<span>{{ $skill->name }}</span></div>@empty<p class="skill-empty">Daftar tools segera hadir.</p>@endforelse</div>
                </article>
            @empty
                <p class="skill-empty">Daftar skills & tools sedang diperbarui.</p>
            @endforelse
        </div>
    </div>
</section>
