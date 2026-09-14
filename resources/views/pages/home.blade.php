@extends('layouts.app')

@section('content')
<!-- HERO -->
    <section
      id="hero"
      class="min-h-screen flex flex-col justify-center relative pt-20 px-4 sm:px-6 overflow-hidden"
      style="background: #fffdf0"
    >
      <!-- Decorative shapes -->
      <div
        class="geo-box"
        style="
          width: 60px;
          height: 60px;
          top: 12%;
          right: 8%;
          background: #ffe44d;
          animation-delay: 0s;
        "
      ></div>
      <div
        class="geo-box"
        style="
          width: 30px;
          height: 30px;
          top: 60%;
          right: 15%;
          background: #ff6b6b;
          animation-delay: 1s;
        "
      ></div>
      <div
        class="geo-circle"
        style="
          width: 80px;
          height: 80px;
          bottom: 20%;
          left: 5%;
          background: #4ecdc4;
          opacity: 0.6;
          animation-delay: 0.5s;
        "
      ></div>
      <div
        class="geo-circle"
        style="
          width: 40px;
          height: 40px;
          top: 25%;
          left: 12%;
          background: #a8ff78;
          animation-delay: 2s;
        "
      ></div>
      <div
        class="geo-spin"
        style="width: 50px; height: 50px; bottom: 30%; right: 6%; opacity: 0.4"
      ></div>
      <div
        class="geo-box"
        style="
          width: 20px;
          height: 20px;
          top: 40%;
          left: 3%;
          background: #1a1a1a;
          animation-delay: 1.5s;
        "
      ></div>

      <div class="max-w-5xl mx-auto w-full">
        <div class="opacity-0 animate-fadeUp animate-delay-1">
          <span class="hero-tag">[ AVAILABLE FOR WORK ]</span>
        </div>
        <h1
          id="scramble-text"
          class="opacity-0 animate-fadeUp animate-delay-2 mt-4 font-extrabold text-4xl sm:text-5xl md:text-7xl leading-none tracking-tight"
          style="font-family: &quot;Syne&quot;, sans-serif"
        >
          MOCHAMAD MIFTAH<br />RACHMATULLAH
        </h1>
        <div
          class="opacity-0 animate-fadeUp animate-delay-3 mt-4 text-lg sm:text-xl font-bold"
          style="font-family: &quot;Syne&quot;, sans-serif"
        >
          <span id="typewriter"></span><span class="typewriter-cursor">|</span>
        </div>
        <p
          class="opacity-0 animate-fadeUp animate-delay-4 mt-5 text-sm sm:text-base max-w-xl leading-relaxed"
          style="color: #444"
        >
          Sebagai seorang developer dan desainer, saya fokus membuat produk
          digital yang tidak cuma fungsional lewat kode yang bersih, tapi juga
          menarik secara visual. Saya suka menggabungkan logika pemrograman
          dengan estetika desain untuk menghasilkan solusi digital yang
          berdampak nyata. Yuk, kolaborasi dan bawa ide-ide hebatmu jadi
          kenyataan.
        </p>
        <div
          class="opacity-0 animate-fadeUp animate-delay-5 flex flex-wrap gap-4 mt-8"
        >
          <a
            href="https://drive.google.com/drive/folders/1kyissT6eNBeT4IQ70fpS8ABLT1S4T1Zw?usp=sharing"
            target="_blank"
            class="nb-btn nb-btn-yellow px-6 py-3 text-base"
            >DOWNLOAD CV</a
          >
          <a
            href="https://drive.google.com/drive/folders/17z-7sFgU_dwpt0ws6Mo1cUGKgSiH_IaS?usp=sharing"
            target="_blank"
            class="nb-btn nb-btn-dark px-6 py-3 text-base"
            >MY PORTFOLIO</a
          >
        </div>
        <div
          class="opacity-0 animate-fadeUp animate-delay-6 mt-10 flex flex-wrap gap-3 text-xs font-bold"
          style="font-family: &quot;Syne&quot;, sans-serif"
        >
          <span
            style="
              border: 2px solid #1a1a1a;
              padding: 4px 12px;
              background: #ff6b6b;
            "
            >HTML</span
          >
          <span
            style="
              border: 2px solid #1a1a1a;
              padding: 4px 12px;
              background: #4ecdc4;
            "
            >REACT</span
          >
          <span
            style="
              border: 2px solid #1a1a1a;
              padding: 4px 12px;
              background: #ffe44d;
            "
            >FIGMA</span
          >
          <span
            style="
              border: 2px solid #1a1a1a;
              padding: 4px 12px;
              background: #a8ff78;
            "
            >LARAVEL</span
          >
          <span
            style="
              border: 2px solid #1a1a1a;
              padding: 4px 12px;
              background: #fff;
            "
            >WEBFLOW</span
          >
        </div>
      </div>
    </section>

    <!-- MARQUEE -->
    <div class="marquee-wrap">
      <div class="marquee-inner">
        <span class="marquee-item">FULLSTACK DEVELOPER</span>
        <span class="marquee-item">UI/UX DESIGNER</span>
        <span class="marquee-item">IT SUPPORT</span>
        <span class="marquee-item">OPEN TO WORK</span>
        <span class="marquee-item">REACT JS</span>
        <span class="marquee-item">FIGMA</span>
        <span class="marquee-item">LARAVEL</span>
        <span class="marquee-item">FRAMER</span>
        <span class="marquee-item">FULLSTACK DEVELOPER</span>
        <span class="marquee-item">UI/UX DESIGNER</span>
        <span class="marquee-item">IT SUPPORT</span>
        <span class="marquee-item">OPEN TO WORK</span>
        <span class="marquee-item">REACT JS</span>
        <span class="marquee-item">FIGMA</span>
        <span class="marquee-item">LARAVEL</span>
        <span class="marquee-item">FRAMER</span>
      </div>
    </div>

    <!-- ABOUT -->
    <section id="about" class="py-24 px-4 sm:px-6" style="background: #fffdf0">
      <div class="max-w-6xl mx-auto">
        <div class="reveal">
          <h2 class="section-heading">
            ABOUT ME.<span class="underline-stroke"></span>
          </h2>
        </div>
        <div class="mt-12 grid md:grid-cols-2 gap-8 items-start">
          <div class="reveal from-left nb-card p-6 bg-white">
            <div
              class="flex flex-col md:flex-row items-center md:items-start gap-6"
            >
              <div class="relative shrink-0 mt-2">
                <div
                  class="absolute inset-0 bg-[#ffe44d] border-3 solid border-[#1a1a1a] rounded-xl translate-x-2 translate-y-2"
                ></div>
                <img
                  src="img/foto-profile.jpg"
                  alt="Mochamad Miftah Rachmatullah"
                  class="relative z-10 w-36 h-36 md:w-40 md:h-40 object-cover border-3 border-[#1a1a1a] rounded-xl bg-white grayscale hover:grayscale-0 transition-all duration-300"
                />
              </div>

              <div class="text-center md:text-left mt-4 md:mt-0">
                <h3
                  style="
                    font-family: &quot;Syne&quot;, sans-serif;
                    font-weight: 800;
                    font-size: 1.25rem;
                  "
                >
                  Mochamad Miftah Rachmatullah
                </h3>
                <p style="color: #666; font-size: 0.8rem; margin-top: 4px">
                  Fullstack Developer ┬À UI/UX Designer ┬À IT Support
                </p>
                <p class="mt-4 text-sm leading-relaxed" style="color: #444">
                  Halo, saya Miftah Rachmatullah. Saya berpengalaman di bidang
                  Web Development, UI/UX Design, dan IT Support. Bagi saya,
                  teknologi yang hebat itu selalu lahir dari kombinasi desain
                  yang ramah pengguna dan baris kode yang rapi.
                </p>
                <p class="mt-3 text-sm leading-relaxed" style="color: #444">
                  Saya suka mengeksplorasi desain modern dan aktif berkontribusi
                  di komunitas IT. Saya selalu terbuka untuk peluang kolaborasi
                  kreatif dan proyek inovatif baru. Yuk, kita kolaborasi.
                </p>
              </div>
            </div>
          </div>

          <div class="reveal from-right grid grid-cols-3 gap-4">
            <div class="nb-card p-5 text-center" style="background: #ff6b6b">
              <div class="stat-num" data-target="2">0</div>
              <div
                style="
                  font-family: &quot;Syne&quot;, sans-serif;
                  font-size: 0.75rem;
                  font-weight: 700;
                "
              >
                + Years<br />Exp
              </div>
            </div>
            <div class="nb-card p-5 text-center" style="background: #4ecdc4">
              <div class="stat-num" data-target="20">0</div>
              <div
                style="
                  font-family: &quot;Syne&quot;, sans-serif;
                  font-size: 0.75rem;
                  font-weight: 700;
                "
              >
                + Projects<br />Done
              </div>
            </div>
            <div class="nb-card p-5 text-center" style="background: #a8ff78">
              <div class="stat-num" data-target="10">0</div>
              <div
                style="
                  font-family: &quot;Syne&quot;, sans-serif;
                  font-size: 0.75rem;
                  font-weight: 700;
                "
              >
                + Happy<br />Clients
              </div>
            </div>
            <div class="nb-card p-5 col-span-3" style="background: #ffe44d">
              <p
                style="
                  font-family: &quot;Syne&quot;, sans-serif;
                  font-weight: 700;
                  font-size: 0.9rem;
                "
              >
                "Saya percaya bahwa design bukan hanya tentang tampilan - tetapi
                tentang bagaimana sesuatu <em>bekerja</em> dan
                <em>dirasakan</em>."
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- SKILLS -->
    <section id="skills" class="py-24 px-4 sm:px-6" style="background: #1a1a1a">
      <div class="max-w-6xl mx-auto">
        <div class="reveal">
          <h2 class="section-heading" style="color: #ffe44d">
            SKILLS &amp; TOOLS.<span
              class="underline-stroke"
              style="background: #ff6b6b; border-color: #ff6b6b"
            ></span>
          </h2>
        </div>
        <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <!-- Frontend -->
          <div
            class="reveal nb-card p-5"
            style="
              background: #fffdf0;
              border-color: #ffe44d;
              box-shadow: 5px 5px 0 #ffe44d;
            "
          >
            <h3
              style="
                font-family: &quot;Syne&quot;, sans-serif;
                font-weight: 800;
                font-size: 1rem;
                margin-bottom: 16px;
                border-bottom: 2px solid #1a1a1a;
                padding-bottom: 8px;
              "
            >
              FRONTEND
            </h3>
            <div class="flex flex-col gap-2">
              <div class="skill-badge">
                <img
                  src="https://cdn.simpleicons.org/html5/E34F26"
                  alt="HTML5"
                />HTML5
              </div>
              <div class="skill-badge">
                <img src="/img/Official_CSS_Logo.png" alt="CSS3" />CSS3
              </div>
              <div class="skill-badge">
                <img
                  src="https://cdn.simpleicons.org/tailwindcss/06B6D4"
                  alt="Tailwind"
                />Tailwind CSS
              </div>
              <div class="skill-badge">
                <img
                  src="https://cdn.simpleicons.org/javascript/F7DF1E"
                  alt="JavaScript"
                />JavaScript
              </div>
              <div class="skill-badge">
                <img
                  src="https://cdn.simpleicons.org/react/61DAFB"
                  alt="React"
                />React.js
              </div>
            </div>
          </div>

          <!-- Backend -->
          <div
            class="reveal nb-card p-5"
            style="
              background: #fffdf0;
              border-color: #ff6b6b;
              box-shadow: 5px 5px 0 #ff6b6b;
              animation-delay: 0.1s;
            "
          >
            <h3
              style="
                font-family: &quot;Syne&quot;, sans-serif;
                font-weight: 800;
                font-size: 1rem;
                margin-bottom: 16px;
                border-bottom: 2px solid #1a1a1a;
                padding-bottom: 8px;
              "
            >
              BACKEND
            </h3>
            <div class="flex flex-col gap-2">
              <div class="skill-badge">
                <img
                  src="https://cdn.simpleicons.org/php/777BB4"
                  alt="PHP"
                />PHP
              </div>
              <div class="skill-badge">
                <img
                  src="https://cdn.simpleicons.org/laravel/FF2D20"
                  alt="Laravel"
                />Laravel
              </div>
              <div class="skill-badge">
                <img
                  src="https://cdn.simpleicons.org/mysql/4479A1"
                  alt="MySQL"
                />MySQL
              </div>
            </div>
          </div>

          <!-- Productivity -->
          <div
            class="reveal nb-card p-5"
            style="
              background: #fffdf0;
              border-color: #4ecdc4;
              box-shadow: 5px 5px 0 #4ecdc4;
              animation-delay: 0.2s;
            "
          >
            <h3
              style="
                font-family: &quot;Syne&quot;, sans-serif;
                font-weight: 800;
                font-size: 1rem;
                margin-bottom: 16px;
                border-bottom: 2px solid #1a1a1a;
                padding-bottom: 8px;
              "
            >
              PRODUCTIVITY
            </h3>
            <div class="flex flex-col gap-2">
              <div class="skill-badge">
                <img
                  src="https://img.icons8.com/color/48/microsoft-word-2025.png"
                  alt="Word"
                />MS Word
              </div>
              <div class="skill-badge">
                <img
                  src="https://img.icons8.com/color/48/microsoft-powerpoint-2025.png"
                  alt="PPT"
                />PowerPoint
              </div>
              <div class="skill-badge">
                <img
                  src="https://img.icons8.com/color/48/microsoft-excel-2025.png"
                  alt="Excel"
                />Excel
              </div>
              <div class="skill-badge">
                <img
                  src="https://cdn.simpleicons.org/trello/0052CC"
                  alt="Trello"
                />Trello
              </div>
            </div>
          </div>

          <!-- Design -->
          <div
            class="reveal nb-card p-5"
            style="
              background: #fffdf0;
              border-color: #a8ff78;
              box-shadow: 5px 5px 0 #a8ff78;
              animation-delay: 0.3s;
            "
          >
            <h3
              style="
                font-family: &quot;Syne&quot;, sans-serif;
                font-weight: 800;
                font-size: 1rem;
                margin-bottom: 16px;
                border-bottom: 2px solid #1a1a1a;
                padding-bottom: 8px;
              "
            >
              DESIGN &amp; NO-CODE
            </h3>
            <div class="flex flex-col gap-2">
              <div class="skill-badge">
                <img
                  src="https://cdn.simpleicons.org/figma/F24E1E"
                  alt="Figma"
                />Figma
              </div>
              <div class="skill-badge">
                <img
                  src="https://cdn.simpleicons.org/framer/0055FF"
                  alt="Framer"
                />Framer
              </div>
              <div class="skill-badge">
                <img
                  src="https://cdn.simpleicons.org/webflow/4353FF"
                  alt="Webflow"
                />Webflow
              </div>
              <div class="skill-badge">
                <img
                  src="/img/whimsical-vertical.svg"
                  alt="Whimsical"
                />Whimsical
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- PROJECTS -->
    <section
      id="projects"
      class="py-24 px-4 sm:px-6"
      style="background: #fffdf0"
    >
      <div class="max-w-6xl mx-auto">
        <div class="reveal flex items-end justify-between flex-wrap gap-4">
          <h2 class="section-heading">
            PROJECTS.<span class="underline-stroke"></span>
          </h2>
          <span
            style="
              font-family: &quot;DM Mono&quot;, monospace;
              font-size: 0.8rem;
              border: 2px solid #1a1a1a;
              padding: 4px 12px;
              background: #ffe44d;
            "
            >09 PROJECTS</span
          >
        </div>
        <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <!-- Project 1 -->
          <div class="reveal nb-card bg-white overflow-hidden">
            <img
              src="/img/ventiflow.png"
              alt="VentiFlow Sistem"
              class="w-full h-40 object-cover project-thumb"
            />
            <div class="p-4">
              <h3
                style="
                  font-family: &quot;Syne&quot;, sans-serif;
                  font-weight: 800;
                  font-size: 1rem;
                "
              >
                VentiFlow Sistem Inventarisasi
              </h3>
              <p class="text-xs mt-1" style="color: #555">
                Sistem pengelola inventaris barang mudah real-time.
              </p>
              <div class="flex flex-wrap gap-1 mt-3">
                <span class="tag-pill">Laravel</span
                ><span class="tag-pill">Tailwind</span
                ><span class="tag-pill">PostgreSQL</span>
              </div>
              <a
                href="#"
                target="_blank"
                class="nb-btn nb-btn-yellow px-4 py-2 text-xs mt-4 block text-center"
                >VIEW PROJECT</a
              >
            </div>
          </div>

          <!-- Project 2 -->
          <div class="reveal nb-card bg-white overflow-hidden">
            <img
              src="/img/landing-page-rs-kembang.png"
              alt="RS Kembang Harapan"
              class="w-full h-40 object-cover project-thumb"
            />
            <div class="p-4">
              <h3
                style="
                  font-family: &quot;Syne&quot;, sans-serif;
                  font-weight: 800;
                  font-size: 1rem;
                "
              >
                Landing Page RS Kembang Harapan
              </h3>
              <p class="text-xs mt-1" style="color: #555">
                Landing page untuk RS Kembang Harapan.
              </p>
              <div class="flex flex-wrap gap-1 mt-3">
                <span class="tag-pill">React</span
                ><span class="tag-pill">SQL</span
                ><span class="tag-pill">Laravel</span>
              </div>
              <a
                href="#"
                target="_blank"
                class="nb-btn nb-btn-yellow px-4 py-2 text-xs mt-4 block text-center"
                >VIEW PROJECT</a
              >
            </div>
          </div>

          <!-- Project 3 -->
          <div class="reveal nb-card bg-white overflow-hidden">
            <img
              src="/img/styalux.png"
              alt="StayLux Hotel Booking App"
              class="w-full h-40 object-cover project-thumb"
            />
            <div class="p-4">
              <h3
                style="
                  font-family: &quot;Syne&quot;, sans-serif;
                  font-weight: 800;
                  font-size: 1rem;
                "
              >
                StayLux Hotel
              </h3>
              <p class="text-xs mt-1" style="color: #555">
                Platform Booking Hotel dengan Harga Terjangkau.
              </p>
              <div class="flex flex-wrap gap-1 mt-3">
                <span class="tag-pill">Html</span
                ><span class="tag-pill">Tailwind</span>
                <span class="tag-pill">Figma</span>
              </div>
              <a
                href="#"
                target="_blank"
                class="nb-btn nb-btn-yellow px-4 py-2 text-xs mt-4 block text-center"
                >VIEW PROJECT</a
              >
            </div>
          </div>

          <!-- Project 4 -->
          <div class="reveal nb-card bg-white overflow-hidden">
            <img
              src="/img/bigbox.png"
              alt="BigBox Project"
              class="w-full h-40 object-cover project-thumb"
            />
            <div class="p-4">
              <h3
                style="
                  font-family: &quot;Syne&quot;, sans-serif;
                  font-weight: 800;
                  font-size: 1rem;
                "
              >
                Helpdesk BigBox
              </h3>
              <p class="text-xs mt-1" style="color: #555">
                Platform penyedia AI untuk solusi perusahaan.
              </p>
              <div class="flex flex-wrap gap-1 mt-3">
                <span class="tag-pill">Figma</span
                ><span class="tag-pill">Tailwind</span
                ><span class="tag-pill">Javascript</span>
              </div>
              <a
                href="#"
                target="_blank"
                class="nb-btn nb-btn-yellow px-4 py-2 text-xs mt-4 block text-center"
                >VIEW PROJECT</a
              >
            </div>
          </div>

          <!-- Project 5 -->
          <div class="reveal nb-card bg-white overflow-hidden">
            <img
              src="/img/inclusive-space.png"
              alt="Inclusive Space"
              class="w-full h-40 object-cover project-thumb"
            />
            <div class="p-4">
              <h3
                style="
                  font-family: &quot;Syne&quot;, sans-serif;
                  font-weight: 800;
                  font-size: 1rem;
                "
              >
                Inclusive Space
              </h3>
              <p class="text-xs mt-1" style="color: #555">
                Platform pembelajaran inclusive.
              </p>
              <div class="flex flex-wrap gap-1 mt-3">
                <span class="tag-pill">Canva</span
                ><span class="tag-pill">Figma</span>
              </div>
              <a
                href="#"
                target="_blank"
                class="nb-btn nb-btn-yellow px-4 py-2 text-xs mt-4 block text-center"
                >VIEW PROJECT</a
              >
            </div>
          </div>

          <!-- Project 6 -->
          <div class="reveal nb-card bg-white overflow-hidden">
            <img
              src="/img/sisarpras.png"
              alt="Sister Sarpas & Sisarpras"
              class="w-full h-40 object-cover project-thumb"
            />
            <div class="p-4">
              <h3
                style="
                  font-family: &quot;Syne&quot;, sans-serif;
                  font-weight: 800;
                  font-size: 1rem;
                "
              >
                Sister Sarpas & Sisarpras
              </h3>
              <p class="text-xs mt-1" style="color: #555">
                Sistem Layanan Sarana dan Prasarana PTN.
              </p>
              <div class="flex flex-wrap gap-1 mt-3">
                <span class="tag-pill">Canva</span
                ><span class="tag-pill">Figma</span
                ><span class="tag-pill">Tailwind</span>
              </div>
              <a
                href="#"
                target="_blank"
                class="nb-btn nb-btn-yellow px-4 py-2 text-xs mt-4 block text-center"
                >VIEW PROJECT</a
              >
            </div>
          </div>

          <!-- Project 7 -->
          <div class="reveal nb-card bg-white overflow-hidden">
            <img
              src="/img/mr-coffee.png"
              alt="MR Coffee Inventory System"
              class="w-full h-40 object-cover project-thumb"
            />
            <div class="p-4">
              <h3
                style="
                  font-family: &quot;Syne&quot;, sans-serif;
                  font-weight: 800;
                  font-size: 1rem;
                "
              >
                MR Coffee
              </h3>
              <p class="text-xs mt-1" style="color: #555">
                MR Coffee is a modern landing page for a coffee shop website.
              </p>
              <div class="flex flex-wrap gap-1 mt-3">
                <span class="tag-pill">Tailwind</span
                ><span class="tag-pill">Javascript</span>
                <span class="tag-pill">Laravel</span>
              </div>
              <a
                href="#"
                target="_blank"
                class="nb-btn nb-btn-yellow px-4 py-2 text-xs mt-4 block text-center"
                >VIEW PROJECT</a
              >
            </div>
          </div>

          <!-- Project 8 -->
          <div class="reveal nb-card bg-white overflow-hidden">
            <img
              src="/img/nexadata.png"
              alt="NexaData Landing Page"
              class="w-full h-40 object-cover project-thumb"
            />
            <div class="p-4">
              <h3
                style="
                  font-family: &quot;Syne&quot;, sans-serif;
                  font-weight: 800;
                  font-size: 1rem;
                "
              >
                NexaData Startup
              </h3>
              <p class="text-xs mt-1" style="color: #555">
                Platform analitik big data untuk perusahaan modern.
              </p>
              <div class="flex flex-wrap gap-1 mt-3">
                <span class="tag-pill">Tailwind</span
                ><span class="tag-pill">Figma</span>
                <span class="tag-pill">Vanilla JavaScript</span>
              </div>
              <a
                href="#"
                target="_blank"
                class="nb-btn nb-btn-yellow px-4 py-2 text-xs mt-4 block text-center"
                >VIEW PROJECT</a
              >
            </div>
          </div>

          <!-- Project 9 -->
          <div class="reveal nb-card bg-white overflow-hidden">
            <img
              src="/img/volva.png"
              alt="Volva Project"
              class="w-full h-40 object-cover project-thumb"
            />
            <div class="p-4">
              <h3
                style="
                  font-family: &quot;Syne&quot;, sans-serif;
                  font-weight: 800;
                  font-size: 1rem;
                "
              >
                Volva EV Landing Page
              </h3>
              <p class="text-xs mt-1" style="color: #555">
                Premium Electric Vehicle Landing Page.
              </p>
              <div class="flex flex-wrap gap-1 mt-3">
                <span class="tag-pill">HTML</span
                ><span class="tag-pill">CSS</span
                ><span class="tag-pill">Tailwind</span>
                <span class="tag-pill">JavaScript</span>
              </div>
              <a
                href="#"
                target="_blank"
                class="nb-btn nb-btn-yellow px-4 py-2 text-xs mt-4 block text-center"
                >VIEW PROJECT</a
              >
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CONTACT -->
    <section
      id="contact"
      class="py-24 px-4 sm:px-6"
      style="
        background: #ffe44d;
        border-top: 3px solid #1a1a1a;
        border-bottom: 3px solid #1a1a1a;
      "
    >
      <div class="max-w-6xl mx-auto">
        <div class="reveal">
          <h2 class="section-heading">
            LET'S WORK<br />TOGETHER.<span
              class="underline-stroke"
              style="background: #ff6b6b; border-color: #1a1a1a"
            ></span>
          </h2>
        </div>
        <div class="mt-12 grid md:grid-cols-5 gap-8">
          <div class="md:col-span-3 reveal from-left">
            <div class="nb-card p-6 bg-white">
              <div id="form-success">
                Ô£à Pesan terkirim! Membuka email client...
              </div>
              <form id="contact-form">
                <div class="mb-4">
                  <label for="fname">NAMA LENGKAP</label>
                  <input
                    type="text"
                    id="fname"
                    name="name"
                    placeholder="Masukkan nama lengkap..."
                    class="nb-input"
                    required
                  />
                </div>
                <div class="mb-4">
                  <label for="femail">EMAIL</label>
                  <input
                    type="email"
                    id="femail"
                    name="email"
                    placeholder="Masukkan email..."
                    class="nb-input"
                    required
                  />
                </div>
                <div class="mb-4">
                  <label for="fmsg">PESAN</label>
                  <textarea
                    id="fmsg"
                    name="message"
                    placeholder="Tuliskan pesan..."
                    class="nb-input nb-textarea"
                    required
                  ></textarea>
                </div>
                <button
                  type="submit"
                  class="nb-btn nb-btn-dark px-6 py-3 text-sm w-full"
                >
                  SEND MESSAGE
                </button>
              </form>
            </div>
          </div>
          <div class="md:col-span-2 reveal from-right flex flex-col gap-4">
            <div class="contact-info-item">
              <div
                style="
                  font-family: &quot;Syne&quot;, sans-serif;
                  font-weight: 800;
                  font-size: 0.75rem;
                  margin-bottom: 4px;
                "
              >
                EMAIL
              </div>
              <div>mochamadmiftah34@gmail.com</div>
            </div>
            <div class="contact-info-item" style="background: #a8ff78">
              <div
                style="
                  font-family: &quot;Syne&quot;, sans-serif;
                  font-weight: 800;
                  font-size: 0.75rem;
                  margin-bottom: 4px;
                "
              >
                LINKEDIN
              </div>
              <div>https://www.linkedin.com/in/miftahrachmatullah/</div>
            </div>
            <div class="contact-info-item" style="background: #ff6b6b">
              <div
                style="
                  font-family: &quot;Syne&quot;, sans-serif;
                  font-weight: 800;
                  font-size: 0.75rem;
                  margin-bottom: 4px;
                "
              >
                LOKASI
              </div>
              <div>Bogor, Indonesia ­ƒç«­ƒç®</div>
            </div>
            <div class="nb-card p-4 bg-white">
              <p
                style="
                  font-family: &quot;Syne&quot;, sans-serif;
                  font-weight: 700;
                  font-size: 0.85rem;
                "
              >
                Respon biasanya dalam
                <strong style="background: #ffe44d; padding: 0 4px"
                  >24 jam</strong
                >
                di hari kerja.
              </p>
            </div>
            <div class="flex gap-3 mt-2">
              <a
                href="https://drive.google.com/drive/folders/1kyissT6eNBeT4IQ70fpS8ABLT1S4T1Zw?usp=sharing"
                target="_blank"
                class="nb-btn nb-btn-dark px-4 py-2 text-sm flex-1 text-center"
                >CV</a
              >
              <a
                href="https://drive.google.com/drive/folders/17z-7sFgU_dwpt0ws6Mo1cUGKgSiH_IaS?usp=sharing"
                target="_blank"
                class="nb-btn nb-btn-red px-4 py-2 text-sm flex-1 text-center"
                >Portfolio</a
              >
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FOOTER -->
@endsection
