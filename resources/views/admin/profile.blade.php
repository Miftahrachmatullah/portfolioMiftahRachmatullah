@extends('layouts.admin')
@section('title', 'Hero & About — Admin MR Portfolio')
@section('content')
<div class="admin-page-heading"><div><p class="admin-eyebrow">THE FACE OF YOUR PORTFOLIO</p><h1>Hero & About<span>.</span></h1><p>Perbarui identitas, foto, tombol, dan cerita Anda dari sini.</p></div><a class="admin-button secondary" href="{{ route('home') }}" target="_blank" rel="noopener noreferrer">Preview landing ↗</a></div>
<form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="admin-profile-form">
    @csrf @method('PUT')
    <section class="admin-panel admin-form-section" id="edit-hero">
        <h2>01 / Hero</h2>
        <label class="admin-checkbox"><input type="checkbox" name="hero_visible" value="1" @checked(old('hero_visible', $profile->hero_visible))> Tampilkan section Hero</label>
        <label>Nama<input name="hero_name" maxlength="120" required value="{{ old('hero_name', $profile->hero_name) }}"></label>
        <label>Role / profesi<textarea name="hero_roles_text" rows="4">{{ old('hero_roles_text', implode("\n", $profile->hero_roles ?? [])) }}</textarea><small>Satu role per baris, maksimal 10. Tambah atau hapus baris untuk mengelola role yang bergantian.</small></label>
        <label>Deskripsi<textarea name="hero_description" rows="6" maxlength="8000">{{ old('hero_description', $profile->hero_description) }}</textarea></label>
        <div class="admin-form-grid">
            <label>Label tombol CV<input name="cv_label" maxlength="50" value="{{ old('cv_label', $profile->cv_label) }}"></label>
            <label>Link CV<input type="url" name="cv_url" maxlength="1000" value="{{ old('cv_url', $profile->cv_url) }}"></label>
            <label>Label tombol portfolio<input name="portfolio_label" maxlength="50" value="{{ old('portfolio_label', $profile->portfolio_label) }}"></label>
            <label>Link portfolio<input type="url" name="portfolio_url" maxlength="1000" value="{{ old('portfolio_url', $profile->portfolio_url) }}"></label>
        </div>
        <p class="admin-help">Kosongkan link jika ingin menyembunyikan salah satu tombol.</p>
        <label>Gaya foto<select name="hero_photo_style">@foreach(['rounded' => 'Rounded — foto biasa', 'arch' => 'Arch — bingkai melengkung', 'cutout' => 'Cutout — untuk PNG / WebP transparan'] as $value => $label)<option value="{{ $value }}" @selected(old('hero_photo_style', $profile->hero_photo_style) === $value)>{{ $label }}</option>@endforeach</select><small>Cutout mempertahankan transparansi file; tidak otomatis menghapus latar foto.</small></label>
        @include('admin.content.photo-field', ['section' => 'hero', 'label' => 'Hero'])
    </section>
    <section class="admin-panel admin-form-section" id="edit-about">
        <h2>02 / About me</h2>
        <label class="admin-checkbox"><input type="checkbox" name="about_visible" value="1" @checked(old('about_visible', $profile->about_visible))> Tampilkan section About</label>
        <div class="admin-form-grid">
            <label>Nama<input name="about_name" maxlength="120" required value="{{ old('about_name', $profile->about_name) }}"></label>
            <label>Role<input name="about_role" maxlength="255" value="{{ old('about_role', $profile->about_role) }}"></label>
        </div>
        <label>Deskripsi / cerita<textarea name="about_description" rows="7" maxlength="10000">{{ old('about_description', $profile->about_description) }}</textarea></label>
        @include('admin.content.photo-field', ['section' => 'about', 'label' => 'About'])
        <div class="admin-form-grid admin-stats-grid">
            <label>Pengalaman (tahun)<input name="years_experience" type="number" required min="0" max="100" value="{{ old('years_experience', $profile->years_experience) }}"></label>
            <label>Total project dikerjakan<input name="projects_completed" type="number" required min="0" max="1000000" value="{{ old('projects_completed', $profile->projects_completed) }}"></label>
            <label>Happy clients<input name="happy_clients" type="number" required min="0" max="1000000" value="{{ old('happy_clients', $profile->happy_clients) }}"></label>
        </div>
        <p class="admin-help">Total project ini adalah angka pengalaman yang Anda isi; dapat mencakup project di luar yang dipajang di portfolio.</p>
        <label>Quote<textarea name="quote" rows="3" maxlength="2000">{{ old('quote', $profile->quote) }}</textarea><small>Kosongkan untuk menyembunyikan quote.</small></label>
    </section>
    <div class="admin-actions"><button class="admin-button" type="submit">Simpan Hero & About ↗</button><a href="{{ route('admin.dashboard') }}" class="admin-button secondary">Kembali</a></div>
</form>
@endsection
