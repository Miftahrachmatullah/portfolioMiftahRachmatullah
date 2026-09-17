@extends('layouts.app')
@section('title', $profile->hero_name.' - Portfolio')
@section('content')
<div id="landing-content" data-endpoint="{{ route('landing.content') }}">@include('components.landing-content')</div>
<p id="landing-sync-status" class="sr-only" role="status" aria-live="polite"></p>

<!-- PROJECTS -->
<section id="projects" class="py-24 px-4 sm:px-6" style="background:#fffdf0">
  <div class="max-w-6xl mx-auto">
    <h2 class="section-heading">PROJECTS.<span class="underline-stroke"></span></h2>
    <form class="portfolio-filters" method="GET" action="{{ route('home') }}#projects">
      <label>Kategori<select name="category"><option value="">Semua kategori</option>@foreach($categories as $category)<option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>@endforeach</select></label>
      <label>Tech stack<select name="technology"><option value="">Semua teknologi</option>@foreach($technologies as $technology)<option value="{{ $technology->slug }}" @selected(request('technology') === $technology->slug)>{{ $technology->name }}</option>@endforeach</select></label>
      <label>Cari project<input type="search" name="q" maxlength="100" value="{{ request('q') }}" placeholder="Judul atau ringkasan"></label>
      <button class="nb-btn nb-btn-yellow px-4 py-2">Terapkan</button><a href="{{ route('home') }}#projects" class="px-3 py-2 underline">Reset</a>
    </form>
    <div id="project-results" data-endpoint="{{ route('projects.fragment') }}">@include('components.project-results')</div>
    <p id="project-sync-status" role="status" aria-live="polite"></p>
  </div>
</section>

<!-- CONTACT -->
<section id="contact" class="py-24 px-4 sm:px-6" style="background:#ffe44d;border-top:3px solid #1a1a1a;border-bottom:3px solid #1a1a1a;">
  <div class="max-w-6xl mx-auto">
    <div class="reveal">
      <h2 class="section-heading">LET'S WORK<br>TOGETHER.<span class="underline-stroke" style="background:#ff6b6b;border-color:#1a1a1a"></span></h2>
    </div>
    <div class="mt-12 grid md:grid-cols-5 gap-8">
      <div class="md:col-span-3 reveal from-left">
        <div class="nb-card p-6 bg-white">
          <div id="form-success">✓ Pesan terkirim! Membuka email client...</div>
          <form id="contact-form">
            <div class="mb-4">
              <label for="fname">NAMA LENGKAP</label>
              <input type="text" id="fname" name="name" placeholder="Masukkan nama lengkap..." class="nb-input" required />
            </div>
            <div class="mb-4">
              <label for="femail">EMAIL</label>
              <input type="email" id="femail" name="email" placeholder="Masukkan email..." class="nb-input" required />
            </div>
            <div class="mb-4">
              <label for="fmsg">PESAN</label>
              <textarea id="fmsg" name="message" placeholder="Tuliskan pesan..." class="nb-input nb-textarea" required></textarea>
            </div>
            <button type="submit" class="nb-btn nb-btn-dark px-6 py-3 text-sm w-full">SEND MESSAGE</button>
          </form>
        </div>
      </div>
      <div class="md:col-span-2 reveal from-right flex flex-col gap-4">
        <div class="contact-info-item">
          <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:0.75rem;margin-bottom:4px;">EMAIL</div>
          <div>mochamadmiftah34@gmail.com</div>
        </div>
        <div class="contact-info-item" style="background:#a8ff78">
          <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:0.75rem;margin-bottom:4px;">LINKEDIN</div>
          <div>https://www.linkedin.com/in/miftahrachmatullah/</div>
        </div>
        <div class="contact-info-item" style="background:#ff6b6b">
          <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:0.75rem;margin-bottom:4px;">LOKASI</div>
          <div>Bogor, Indonesia 🇮🇩</div>
        </div>
        <div class="nb-card p-4 bg-white">
          <p style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.85rem;">Respon biasanya dalam <strong style="background:#ffe44d;padding:0 4px">24 jam</strong> di hari kerja.</p>
        </div>
        <div class="flex gap-3 mt-2">
          <a href="https://drive.google.com/drive/folders/1kyissT6eNBeT4IQ70fpS8ABLT1S4T1Zw?usp=sharing" target="_blank" class="nb-btn nb-btn-dark px-4 py-2 text-sm flex-1 text-center">CV</a>
          <a href="https://www.linkedin.com/in/miftahrachmatullah/" target="_blank" class="nb-btn nb-btn-red px-4 py-2 text-sm flex-1 text-center">LinkedIn</a>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
