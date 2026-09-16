@extends('layouts.admin')
@section('title', 'Projects — Admin MR Portfolio')
@section('content')
<div class="admin-page-heading"><div><p class="admin-eyebrow">YOUR WORK, ALL IN ONE PLACE</p><h1>Projects<span>.</span></h1><p>Kelola karya yang tampil di portfolio Anda.</p></div><a class="admin-button" href="{{ route('admin.projects.create') }}">＋ Tambah project</a></div>
<div class="admin-stats"><div><span>TOTAL PROJECT</span><strong>{{ $counts['all'] }}</strong></div><div><span>PUBLISHED</span><strong>{{ $counts['published'] }}</strong></div><div><span>DRAFT</span><strong>{{ $counts['draft'] }}</strong></div></div>
<section class="admin-panel">
<form class="admin-filters" action="{{ route('admin.dashboard') }}" method="GET">
    <label>Cari project<input name="q" value="{{ request('q') }}" placeholder="Judul atau ringkasan" maxlength="100"></label>
    <label>Status<select name="status"><option value="">Semua status</option>@foreach(['draft' => 'Draft', 'published' => 'Published', 'trash' => 'Sampah'] as $value => $label)<option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>@endforeach</select></label>
    <label>Kategori<select name="category"><option value="">Semua kategori</option>@foreach($categories as $category)<option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>@endforeach</select></label>
    <label>Urutan<select name="sort">@foreach(['order' => 'Urutan tampil', 'newest' => 'Terbaru', 'title' => 'Judul A–Z'] as $value => $label)<option value="{{ $value }}" @selected(request('sort', 'order') === $value)>{{ $label }}</option>@endforeach</select></label>
    <button class="admin-button secondary">Terapkan</button><a href="{{ route('admin.dashboard') }}" class="admin-reset">Reset</a>
</form>
<div class="admin-table-wrap"><table class="admin-table">
    <caption class="sr-only">Daftar project portfolio, 10 item per halaman</caption>
    <thead><tr><th scope="col">Project</th><th scope="col">Status</th><th scope="col">Kategori</th><th scope="col">Urutan</th><th scope="col">Aksi</th></tr></thead>
    <tbody>@forelse($projects as $project)<tr>
        <td><div class="admin-project-name">@if($project->cover_url)<img src="{{ $project->cover_url }}" alt="{{ $project->cover_alt ?: $project->title }}" width="72" height="54" loading="lazy">@else<div class="admin-cover-empty">MR.</div>@endif<div><strong>{{ $project->title }}</strong><small>{{ Str::limit($project->summary, 70) }}</small>@if($project->featured)<span class="admin-featured">★ Featured</span>@endif</div></div></td>
        <td><span class="admin-badge {{ $project->status }}">{{ $project->trashed() ? 'Sampah' : ucfirst($project->status) }}</span></td>
        <td>{{ $project->categories->pluck('name')->join(', ') ?: '—' }}</td><td>{{ $project->sort_order }}</td>
        <td><div class="admin-row-actions">@if($project->trashed())
            <form method="POST" action="{{ route('admin.projects.restore', $project) }}">@csrf<button class="admin-button secondary">Pulihkan</button></form>
        @else
            <a href="{{ route('admin.projects.show', $project) }}" class="admin-action-link">Detail</a><a href="{{ route('admin.projects.edit', $project) }}" class="admin-action-link">Edit</a>
            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" data-delete-form>@csrf @method('DELETE')<button class="admin-action-link danger-text" type="submit">Hapus</button></form>
        @endif</div></td>
    </tr>@empty<tr><td colspan="5" class="admin-empty"><strong>Belum ada project di daftar ini.</strong><p>Ubah filter atau tambahkan karya pertama Anda.</p></td></tr>@endforelse</tbody>
</table></div>
<div class="admin-pagination">{{ $projects->links() }}</div>
</section>
@endsection
