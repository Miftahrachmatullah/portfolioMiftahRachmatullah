@extends('layouts.admin')
@section('title', $heading.' — Admin MR Portfolio')
@section('content')
<div class="admin-page-heading"><div><p class="admin-eyebrow">LANDING PAGE CONTENT</p><h1>{{ $heading }}<span>.</span></h1><p>Atur konten dan urutan tampil di landing page.</p></div><a class="admin-button" href="{{ route('admin.'.$resource.'.create') }}">＋ Tambah</a></div>
@if($resource === 'skills')<p class="admin-help">Kelola kelompok seperti Frontend dan Backend di <a href="{{ route('admin.skill-groups.index') }}">Kategori skill</a>.</p>@endif
<section class="admin-panel">
<form class="admin-filters" method="GET" action="{{ route('admin.'.$resource.'.index') }}">
    <label>Cari<input name="q" maxlength="100" value="{{ request('q') }}" placeholder="Nama konten"></label>
    <label>Status<select name="status"><option value="">Semua status</option>@foreach(['visible' => 'Tampil', 'hidden' => 'Disembunyikan', 'trash' => 'Sampah'] as $value => $label)<option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>@endforeach</select></label>
    <button class="admin-button secondary">Terapkan</button><a class="admin-reset" href="{{ route('admin.'.$resource.'.index') }}">Reset</a>
</form>
<div class="admin-table-wrap"><table class="admin-table">
    <caption class="sr-only">Daftar {{ $heading }}, 10 item per halaman</caption>
    <thead><tr><th scope="col">Nama</th>@if($resource === 'skills')<th scope="col">Kategori</th>@endif<th scope="col">Status</th><th scope="col">Urutan</th><th scope="col">Aksi</th></tr></thead>
    <tbody>@forelse($items as $item)<tr>
        <td><strong>{{ $item->name }}</strong></td>
        @if($resource === 'skills')<td>{{ $item->group?->name ?? 'Kategori di sampah' }}</td>@endif
        <td><span class="admin-badge {{ $item->is_visible ? 'published' : 'draft' }}">{{ $item->trashed() ? 'Sampah' : ($item->is_visible ? 'Tampil' : 'Disembunyikan') }}</span></td>
        <td>{{ $item->sort_order }}</td>
        <td><div class="admin-row-actions">@if($item->trashed())
            <form method="POST" action="{{ route('admin.'.$resource.'.restore', $item) }}">@csrf<button class="admin-button secondary">Pulihkan</button></form>
        @else
            <a class="admin-action-link" href="{{ route('admin.'.$resource.'.show', $item) }}">Detail</a>
            <a class="admin-action-link" href="{{ route('admin.'.$resource.'.edit', $item) }}">Edit</a>
            <form method="POST" action="{{ route('admin.'.$resource.'.destroy', $item) }}" data-delete-form data-delete-title="Hapus {{ $heading }}?" data-delete-message="Konten akan dipindahkan ke sampah dan dapat dipulihkan.{{ $resource === 'skill-groups' ? ' Skill pada kategori ini ikut disembunyikan.' : '' }}">@csrf @method('DELETE')<button class="admin-action-link danger-text">Hapus</button></form>
        @endif</div></td>
    </tr>@empty<tr><td colspan="{{ $resource === 'skills' ? 5 : 4 }}" class="admin-empty">Belum ada konten. Tambahkan item atau ubah filter.</td></tr>@endforelse</tbody>
</table></div>
<div class="admin-pagination">{{ $items->links() }}</div>
</section>
@endsection
