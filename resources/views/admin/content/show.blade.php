@extends('layouts.admin')
@section('title', 'Detail '.$heading.' — MR Portfolio')
@section('content')
<a class="admin-back" href="{{ route('admin.'.$resource.'.index') }}">← {{ $heading }}</a>
<div class="admin-page-heading"><div><p class="admin-eyebrow">DETAIL KONTEN</p><h1>{{ $item->name }}</h1></div><a class="admin-button" href="{{ route('admin.'.$resource.'.edit', $item) }}">Edit</a></div>
<section class="admin-panel admin-form-section">
    <dl class="admin-form-grid">
        <div><dt>Status</dt><dd>{{ $item->is_visible ? 'Tampil' : 'Disembunyikan' }}</dd></div>
        <div><dt>Urutan</dt><dd>{{ $item->sort_order }}</dd></div>
        @if($resource === 'skills')
            <div><dt>Kategori</dt><dd>{{ $item->group?->name ?? 'Kategori di sampah (skill tidak tampil)' }}</dd></div>
            <div><dt>URL ikon</dt><dd class="break-all">{{ $item->icon_url ?: 'Inisial nama' }}</dd></div>
        @endif
        @if($resource === 'skill-groups')
            <div><dt>Warna aksen</dt><dd>{{ $item->accent }}</dd></div>
            <div><dt>Jumlah skill aktif</dt><dd>{{ $item->skills()->count() }}</dd></div>
        @endif
        <div><dt>Dibuat</dt><dd>{{ $item->created_at?->format('d M Y, H:i') }}</dd></div>
        <div><dt>Diperbarui</dt><dd>{{ $item->updated_at?->format('d M Y, H:i') }}</dd></div>
    </dl>
</section>
@endsection
