@extends('layouts.admin')
@section('title', $project->title.' — Admin MR Portfolio')
@section('content')
<a class="admin-back" href="{{ route('admin.dashboard') }}">← Semua projects</a>
<div class="admin-page-heading"><div><p class="admin-eyebrow">PROJECT DETAIL</p><h1>{{ $project->title }}</h1><span class="admin-badge {{ $project->status }}">{{ ucfirst($project->status) }}</span></div>
<div class="admin-actions"><a class="admin-button" href="{{ route('admin.projects.edit', $project) }}">Edit project</a>@if($project->status === 'published')<a class="admin-button secondary" href="{{ route('projects.show', $project->slug) }}">Lihat publik ↗</a>@endif</div></div>
<section class="admin-panel admin-form-section">@include('components.project-detail')
<dl class="project-metadata"><div><dt>Slug</dt><dd>{{ $project->slug }}</dd></div><div><dt>Urutan</dt><dd>{{ $project->sort_order }}</dd></div><div><dt>Published</dt><dd>{{ $project->published_at?->format('d M Y H:i') ?? 'Belum dipublish' }}</dd></div><div><dt>Diperbarui</dt><dd>{{ $project->updated_at->format('d M Y H:i') }}</dd></div></dl>
<form action="{{ route('admin.projects.destroy', $project) }}" method="POST" data-delete-form>@csrf @method('DELETE')<button class="admin-button danger">Hapus project</button></form>
</section>
@endsection
