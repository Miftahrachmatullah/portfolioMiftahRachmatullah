@if($project->cover_url)<img class="project-detail-cover" src="{{ $project->cover_url }}" alt="{{ $project->cover_alt ?: $project->title }}" width="1200" height="800">@endif
<p class="project-summary">{{ $project->summary }}</p>
<p class="project-prose">{{ $project->description }}</p>
<div class="project-detail-grid">@foreach(['problem' => 'Problem', 'goal' => 'Goal', 'role' => 'Role', 'result' => 'Result'] as $field => $label)@if($project->$field)<section><h2>{{ $label }}</h2><p class="project-prose">{{ $project->$field }}</p></section>@endif @endforeach</div>
@if($project->flow_steps)<section class="project-flow"><h2>Process / flow</h2><ol>@foreach($project->flow_steps as $step)<li>{{ $step }}</li>@endforeach</ol></section>@endif
<div class="project-tags">@foreach($project->categories as $category)<span>{{ $category->name }}</span>@endforeach @foreach($project->technologies as $technology)<span>{{ $technology->name }}</span>@endforeach</div>
<div class="admin-actions">@foreach(['demo_url' => 'Live demo ↗', 'repository_url' => 'Repository ↗'] as $field => $label)@if($project->$field && preg_match('#^https?://#i', $project->$field))<a class="admin-button secondary" href="{{ $project->$field }}" target="_blank" rel="noopener noreferrer">{{ $label }}</a>@endif @endforeach</div>
