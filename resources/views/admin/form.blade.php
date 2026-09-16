@extends('layouts.admin')
@section('title', ($project->exists ? 'Edit' : 'Tambah').' Project — MR Portfolio')
@section('content')
<a class="admin-back" href="{{ route('admin.dashboard') }}">← Semua projects</a>
<div class="admin-page-heading"><div><p class="admin-eyebrow">MAKE YOUR WORK VISIBLE</p><h1>{{ $project->exists ? 'Edit project' : 'Tambah project' }}<span>.</span></h1><p>Simpan draft untuk persiapan, pilih published untuk menampilkannya di landing page.</p></div></div>
<form class="admin-project-form" method="POST" enctype="multipart/form-data" action="{{ $project->exists ? route('admin.projects.update', $project) : route('admin.projects.store') }}">
@csrf @if($project->exists) @method('PUT') @endif
<section class="admin-panel admin-form-section"><h2>01 / Informasi project</h2>
    <label>Judul <span aria-hidden="true">*</span><input name="title" value="{{ old('title', $project->title) }}" maxlength="255" required></label>
    <label>Ringkasan<textarea name="summary" rows="2" maxlength="500">{{ old('summary', $project->summary) }}</textarea><small>Teks singkat untuk kartu di landing page. Maksimal 500 karakter.</small></label>
    <label>Deskripsi<textarea name="description" rows="5" maxlength="20000">{{ old('description', $project->description) }}</textarea></label>
    <div class="admin-form-grid"><label>Kategori<input name="categories" value="{{ is_array(old('categories')) ? implode(', ', old('categories')) : old('categories', $project->categories->pluck('name')->join(', ')) }}" list="category-options"><small>Pisahkan dengan koma, contoh: UI/UX, Frontend</small></label>
    <label>Tech stack<input name="technologies" value="{{ is_array(old('technologies')) ? implode(', ', old('technologies')) : old('technologies', $project->technologies->pluck('name')->join(', ')) }}" list="technology-options"><small>Pisahkan dengan koma, contoh: Laravel, PostgreSQL</small></label></div>
    <datalist id="category-options">@foreach($categories as $category)<option value="{{ $category->name }}">@endforeach</datalist>
    <datalist id="technology-options">@foreach($technologies as $technology)<option value="{{ $technology->name }}">@endforeach</datalist>
</section>
<section class="admin-panel admin-form-section"><h2>02 / Cover image</h2>
    <div class="admin-upload"><img id="cover-preview" src="{{ $project->cover_url ?: '' }}" alt="Preview cover project" @if(!$project->cover_url) hidden @endif><label>Upload cover<input id="cover-upload" name="cover_image" type="file" accept="image/jpeg,image/png,image/webp" data-current-cover="{{ $project->cover_url }}"><small>JPG, PNG, WebP. Maksimal 3 MB dan 6000 × 6000 px. Upload ulang jika validasi form gagal.</small></label><p id="cover-error" role="alert"></p></div>
    <label>Deskripsi gambar / alt text<input name="cover_alt" value="{{ old('cover_alt', $project->cover_alt) }}" maxlength="255"><small>Wajib untuk cover baru. Jelaskan gambar dengan singkat.</small></label>
</section>
<section class="admin-panel admin-form-section"><h2>03 / Case study</h2>
    <div class="admin-form-grid">@foreach(['problem' => 'Problem', 'goal' => 'Goal', 'role' => 'Peran Anda', 'result' => 'Hasil'] as $field => $label)<label>{{ $label }}<textarea name="{{ $field }}" rows="3" maxlength="{{ $field === 'role' ? 255 : 10000 }}">{{ old($field, $project->$field) }}</textarea></label>@endforeach</div>
    <label>Process / flow<textarea name="flow_text" rows="6">{{ old('flow_text', implode("\n", $project->flow_steps ?? [])) }}</textarea><small>Satu langkah per baris, maksimal 30 langkah.</small></label>
</section>
<section class="admin-panel admin-form-section"><h2>04 / Publish & links</h2>
    <div class="admin-form-grid">
        <label>URL demo<input name="demo_url" type="url" value="{{ old('demo_url', $project->demo_url) }}" maxlength="255" placeholder="https://..."></label>
        <label>URL repository<input name="repository_url" type="url" value="{{ old('repository_url', $project->repository_url) }}" maxlength="255" placeholder="https://github.com/..."></label>
        <label>Status<select name="status" required><option value="draft" @selected(old('status', $project->status) === 'draft')>Draft — hanya admin</option><option value="published" @selected(old('status', $project->status) === 'published')>Published — tampil di landing page</option></select></label>
        <label>Urutan tampil<input name="sort_order" type="number" min="0" max="1000000" value="{{ old('sort_order', $project->sort_order ?? 0) }}"><small>Angka kecil tampil lebih awal.</small></label>
    </div>
    <label class="admin-checkbox"><input name="featured" type="checkbox" value="1" @checked(old('featured', $project->featured))> Tandai sebagai featured</label>
</section>
<div class="admin-actions"><button class="admin-button" type="submit">Simpan project ↗</button><a class="admin-button secondary" href="{{ route('admin.dashboard') }}">Batal</a></div>
</form>
@endsection
