@extends('layouts.admin')
@section('title', ($item->exists ? 'Edit ' : 'Tambah ').$heading.' — MR Portfolio')
@section('content')
<a class="admin-back" href="{{ route('admin.'.$resource.'.index') }}">← {{ $heading }}</a>
<div class="admin-page-heading"><div><p class="admin-eyebrow">LANDING PAGE CONTENT</p><h1>{{ $item->exists ? 'Edit' : 'Tambah' }} {{ $heading }}</h1></div></div>
<form method="POST" action="{{ $item->exists ? route('admin.'.$resource.'.update', $item) : route('admin.'.$resource.'.store') }}">
    @csrf @if($item->exists) @method('PUT') @endif
    <section class="admin-panel admin-form-section">
        <label>Nama<input name="name" required maxlength="100" value="{{ old('name', $item->name) }}"></label>
        @if($resource === 'skills')
            <label>Kategori<select name="skill_group_id" required><option value="">Pilih kategori</option>@foreach($groups as $group)<option value="{{ $group->id }}" @selected((string) old('skill_group_id', $item->skill_group_id) === (string) $group->id)>{{ $group->name }}{{ !$group->is_visible ? ' (disembunyikan)' : '' }}</option>@endforeach</select></label>
            @if($groups->isEmpty())<p>Buat <a href="{{ route('admin.skill-groups.create') }}">kategori skill</a> terlebih dahulu.</p>@endif
            <label>URL ikon (opsional)<input name="icon_url" maxlength="1000" value="{{ old('icon_url', $item->icon_url) }}" placeholder="https://..."><small>HTTPS atau aset /img/. Kosongkan untuk memakai inisial nama.</small></label>
        @endif
        @if($resource === 'skill-groups')
            <label>Warna aksen<select name="accent">@foreach(['yellow' => 'Kuning', 'red' => 'Coral', 'teal' => 'Toska', 'lime' => 'Lime'] as $value => $label)<option value="{{ $value }}" @selected(old('accent', $item->accent) === $value)>{{ $label }}</option>@endforeach</select></label>
        @endif
        <label>Urutan tampil<input name="sort_order" type="number" required min="0" max="1000000" value="{{ old('sort_order', $item->sort_order ?? 0) }}"><small>Angka kecil tampil lebih dahulu.</small></label>
        <label class="admin-checkbox"><input name="is_visible" type="checkbox" value="1" @checked(old('is_visible', $item->is_visible))> Tampilkan di landing page</label>
        <div class="admin-actions"><button class="admin-button">Simpan</button><a class="admin-button secondary" href="{{ route('admin.'.$resource.'.index') }}">Batal</a></div>
    </section>
</form>
@endsection
