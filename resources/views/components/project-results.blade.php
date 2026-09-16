<div class="project-results-meta"><p>{{ $projects->total() }} PROJECTS</p><span>Published work</span></div>
<div class="mt-8 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
@forelse($projects as $project)
<article class="project-card nb-card bg-white overflow-hidden">
    @if($project->cover_url)<img src="{{ $project->cover_url }}" alt="{{ $project->cover_alt ?: $project->title }}" class="w-full h-48 object-cover project-thumb" width="720" height="480" loading="lazy">@else<div class="project-placeholder" aria-hidden="true">MR.</div>@endif
    <div class="p-5"><div class="project-tags">@foreach($project->categories as $category)<span>{{ $category->name }}</span>@endforeach @if($project->featured)<span>★ FEATURED</span>@endif</div>
    <h3 class="text-xl font-bold mt-4">{{ $project->title }}</h3><p class="text-sm mt-3">{{ $project->summary }}</p>
    <div class="project-tags mt-3">@foreach($project->technologies as $technology)<span>{{ $technology->name }}</span>@endforeach</div>
    <a class="nb-btn nb-btn-yellow px-4 py-3 text-xs mt-4 w-full text-center" href="{{ route('projects.show', $project->slug) }}">DETAIL PROJECT ↗</a></div>
</article>
@empty<div class="project-empty"><h3>Belum ada project yang cocok.</h3><p>Coba kategori lain atau reset filter.</p><a href="{{ route('home') }}#projects">Reset filter</a></div>@endforelse
</div>
<div class="project-pagination">{{ $projects->links() }}</div>
