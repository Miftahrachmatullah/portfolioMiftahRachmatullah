<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Admin — MR Portfolio')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Syne:wght@700;800&display=swap">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-body">
<a class="admin-skip" href="#content">Lewati ke konten</a>
<header class="admin-header">
    <a href="{{ route('admin.dashboard') }}" class="admin-brand">MR<span>.</span> / STUDIO</a>
    <nav aria-label="Navigasi admin"><a href="{{ route('home') }}">Lihat portfolio ↗</a><form action="{{ route('logout') }}" method="POST">@csrf<button class="admin-button secondary" type="submit">Logout</button></form></nav>
</header>
<div class="admin-shell">
    <aside class="admin-sidebar">
        <span class="admin-eyebrow">WORKSPACE</span>
        <a class="{{ request()->routeIs('admin.dashboard', 'admin.projects.*') ? 'admin-nav-active' : '' }}" href="{{ route('admin.dashboard') }}">▦ &nbsp; Projects</a>
        <a href="{{ route('admin.projects.create') }}">＋ &nbsp; Tambah project</a>
        <a href="{{ route('admin.dashboard', ['status' => 'trash']) }}">↶ &nbsp; Sampah</a>
        @foreach(['profile.edit' => 'Hero & About', 'marquee.index' => 'Teks berjalan', 'skill-groups.index' => 'Kategori skill', 'skills.index' => 'Skills & Tools'] as $destination => $label)
            <a href="{{ route('admin.'.$destination) }}" class="{{ request()->routeIs('admin.'.Str::before($destination, '.').'.*') ? 'admin-nav-active' : '' }}">{{ $label }}</a>
        @endforeach
        <div class="admin-user"><strong>{{ auth()->user()->name }}</strong><span>ADMINISTRATOR</span></div>
    </aside>
    <main id="content" class="admin-main">
        @if(session('success'))<div role="status" class="admin-alert success">{{ session('success') }}</div>@endif
        @if($errors->any())<div role="alert" class="admin-alert error"><strong>Periksa kembali form:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        @yield('content')
    </main>
</div>
<dialog id="delete-dialog" class="admin-dialog">
    <h2 data-delete-heading>Hapus project?</h2><p data-delete-message>Project akan hilang dari landing page dan dipindahkan ke sampah. Data dan cover masih dapat dipulihkan.</p>
    <div class="admin-actions"><button type="button" class="admin-button secondary" data-cancel-delete>Batal</button><button type="button" class="admin-button danger" data-confirm-delete>Ya, pindahkan ke sampah</button></div>
</dialog>
</body>
</html>
