<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Mochamad Miftah Rachmatullah - Portfolio')</title>
    <meta name="description" content="Portfolio Mochamad Miftah Rachmatullah - Fullstack Developer, UI/UX Designer, IT Support" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=DM+Mono:wght@400;500&display=swap");

      * { cursor: none !important; box-sizing: border-box; }
      html { scroll-behavior: smooth; }
      body { font-family: "DM Mono", monospace; background: #fffdf0; color: #1a1a1a; overflow-x: hidden; }

      body::before {
        content: "";
        position: fixed;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
        pointer-events: none;
        z-index: 9999;
        opacity: 0.5;
      }

      /* CURSOR */
      #cursor { position: fixed; width: 12px; height: 12px; background: #1a1a1a; pointer-events: none; z-index: 99999; transition: transform 0.1s; mix-blend-mode: difference; }
      #cursor-ring { position: fixed; width: 32px; height: 32px; border: 2px solid #1a1a1a; pointer-events: none; z-index: 99998; transition: all 0.15s ease; mix-blend-mode: difference; }

      /* KEYFRAMES */
      @keyframes fadeUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
      @keyframes marquee { from { transform: translateX(0); } to { transform: translateX(-50%); } }
      @keyframes floatBox { 0%,100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-15px) rotate(5deg); } }
      @keyframes floatCircle { 0%,100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-20px) rotate(-8deg); } }
      @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
      @keyframes blink { 0%,100% { opacity: 1; } 50% { opacity: 0; } }
      @keyframes slideIn { from { opacity: 0; transform: translateX(-30px); } to { opacity: 1; transform: translateX(0); } }
      @keyframes pulseYellow { 0%,100% { box-shadow: 4px 4px 0 #1a1a1a; } 50% { box-shadow: 6px 6px 0 #ffe44d; } }

      .animate-fadeUp { animation: fadeUp 0.7s ease forwards; }
      .animate-delay-1 { animation-delay: 0.1s; }
      .animate-delay-2 { animation-delay: 0.2s; }
      .animate-delay-3 { animation-delay: 0.3s; }
      .animate-delay-4 { animation-delay: 0.4s; }
      .animate-delay-5 { animation-delay: 0.5s; }
      .animate-delay-6 { animation-delay: 0.6s; }
      .opacity-0 { opacity: 0; }

      /* REVEAL on scroll */
      .reveal { opacity: 0; transform: translateY(50px); transition: opacity 0.6s ease, transform 0.6s ease; }
      .reveal.from-left { transform: translateX(-50px); }
      .reveal.from-right { transform: translateX(50px); }
      .reveal.visible { opacity: 1; transform: translate(0); }

      /* NEOBRUTALISM BASE */
      .nb-card { border: 3px solid #1a1a1a; box-shadow: 5px 5px 0 #1a1a1a; transition: transform 0.15s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.15s cubic-bezier(0.34,1.56,0.64,1); }
      .nb-card:hover { transform: translateY(-4px); box-shadow: 8px 8px 0 #1a1a1a; }

      .nb-btn { border: 3px solid #1a1a1a; font-family: "Syne", sans-serif; font-weight: 700; letter-spacing: 0.05em; transition: transform 0.1s, box-shadow 0.1s; display: inline-block; text-decoration: none; }
      .nb-btn:hover { transform: translateY(-2px); }
      .nb-btn:active { transform: translateY(3px) !important; box-shadow: 1px 1px 0 #1a1a1a !important; }

      .nb-btn-yellow { background: #ffe44d; box-shadow: 4px 4px 0 #1a1a1a; color: #1a1a1a; }
      .nb-btn-yellow:hover { box-shadow: 6px 6px 0 #1a1a1a; }
      .nb-btn-dark { background: #1a1a1a; color: #fff; box-shadow: 4px 4px 0 #ff6b6b; }
      .nb-btn-dark:hover { box-shadow: 6px 6px 0 #ff6b6b; }
      .nb-btn-red { background: #ff6b6b; color: #1a1a1a; box-shadow: 4px 4px 0 #1a1a1a; }
      .nb-btn-red:hover { box-shadow: 6px 6px 0 #1a1a1a; }

      /* FONT */
      h1,h2,h3,.font-syne { font-family: "Syne", sans-serif; }

      /* NAVBAR */
      #navbar { position: fixed; top: 0; left: 0; right: 0; z-index: 1000; background: #fffdf0; border-bottom: 3px solid #1a1a1a; transition: background 0.3s; }
      #navbar.scrolled { background: #ffe44d; }
      .nav-link { font-family: "Syne", sans-serif; font-weight: 700; position: relative; padding-bottom: 2px; }
      .nav-link::after { content: ""; position: absolute; bottom: 0; left: 0; width: 0; height: 2px; background: #1a1a1a; transition: width 0.25s ease; }
      .nav-link:hover::after { width: 100%; }

      /* HERO */
      .hero-tag { border: 2px solid #1a1a1a; font-family: "DM Mono", monospace; font-size: 0.75rem; padding: 4px 10px; display: inline-block; background: #a8ff78; }
      .geo-box { position: absolute; border: 3px solid #1a1a1a; animation: floatBox 4s ease-in-out infinite; }
      .geo-circle { position: absolute; border: 3px solid #1a1a1a; border-radius: 50%; animation: floatCircle 5s ease-in-out infinite; }
      .geo-spin { position: absolute; border: 3px solid #1a1a1a; animation: spin 10s linear infinite; }
      .typewriter-cursor { animation: blink 1s infinite; }

      /* MARQUEE */
      .marquee-wrap { overflow: hidden; background: #1a1a1a; border-top: 3px solid #1a1a1a; border-bottom: 3px solid #1a1a1a; }
      .marquee-inner { display: flex; white-space: nowrap; animation: marquee 20s linear infinite; }
      .marquee-item { font-family: "Syne", sans-serif; font-weight: 700; font-size: 1.1rem; padding: 12px 32px; color: #ffe44d; }

      /* SKILLS */
      .skill-badge { border: 2px solid #1a1a1a; padding: 10px 14px; background: #fff; display: flex; align-items: center; gap: 10px; transition: transform 0.15s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.15s; box-shadow: 3px 3px 0 #1a1a1a; font-family: "DM Mono", monospace; font-size: 0.8rem; font-weight: 500; }
      .skill-badge:hover { transform: translateY(-3px); box-shadow: 5px 5px 0 #1a1a1a; }
      .skill-badge img { width: 28px; height: 28px; object-fit: contain; transition: transform 0.4s; }
      .skill-badge:hover img { transform: rotateY(360deg); }

      /* STAT */
      .stat-num { font-family: "Syne", sans-serif; font-size: 2.5rem; font-weight: 800; }

      /* PROJECT CARD */
      .project-thumb { height: 160px; border-bottom: 3px solid #1a1a1a; display: flex; align-items: center; justify-content: center; font-family: "Syne", sans-serif; font-weight: 800; font-size: 1.5rem; letter-spacing: 0.1em; }
      .tag-pill { border: 2px solid #1a1a1a; font-size: 0.65rem; padding: 2px 8px; font-family: "DM Mono", monospace; background: #ffe44d; display: inline-block; }

      /* FILTER PILLS */
      .filter-btn { border: 2px solid #1a1a1a; font-family: "Syne", sans-serif; font-weight: 700; font-size: 0.75rem; padding: 6px 16px; cursor: none; transition: all 0.15s; background: #fff; box-shadow: 3px 3px 0 #1a1a1a; }
      .filter-btn:hover { transform: translateY(-2px); box-shadow: 5px 5px 0 #1a1a1a; }
      .filter-btn.active { background: #1a1a1a; color: #ffe44d; box-shadow: 4px 4px 0 #ffe44d; }

      /* PROJECT MODAL */
      #project-modal { display: none; position: fixed; inset: 0; z-index: 9000; background: rgba(26,26,26,0.8); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px; }
      #project-modal.open { display: flex; }
      #modal-content { background: #fffdf0; border: 3px solid #1a1a1a; box-shadow: 10px 10px 0 #1a1a1a; max-width: 680px; width: 100%; max-height: 90vh; overflow-y: auto; position: relative; }
      #modal-close { position: absolute; top: 12px; right: 14px; font-family: "Syne", sans-serif; font-weight: 800; font-size: 1.2rem; background: #ff6b6b; border: 2px solid #1a1a1a; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: none; box-shadow: 2px 2px 0 #1a1a1a; }
      #modal-close:hover { transform: translateY(-2px); box-shadow: 4px 4px 0 #1a1a1a; }

      /* FORM */
      .nb-input { border: 2px solid #1a1a1a; background: #fff; font-family: "DM Mono", monospace; padding: 10px 14px; width: 100%; outline: none; box-shadow: 3px 3px 0 #1a1a1a; transition: box-shadow 0.2s, transform 0.2s; }
      .nb-input:focus { box-shadow: 5px 5px 0 #1a1a1a; transform: translateY(-2px); }
      .nb-textarea { resize: vertical; min-height: 120px; }
      label { font-family: "Syne", sans-serif; font-weight: 700; font-size: 0.85rem; display: block; margin-bottom: 6px; }

      /* HAMBURGER */
      .hamburger-line { display: block; width: 24px; height: 3px; background: #1a1a1a; transition: transform 0.3s, opacity 0.3s; }
      #mobile-menu { display: none; border-top: 3px solid #1a1a1a; background: #fffdf0; }
      #mobile-menu.open { display: block; }
      #mobile-menu.open.scrolled { background: #ffe44d; }

      /* SOCIAL */
      .social-icon { width: 44px; height: 44px; border: 2px solid #1a1a1a; display: flex; align-items: center; justify-content: center; box-shadow: 3px 3px 0 #1a1a1a; transition: transform 0.15s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.15s; background: #fff; }
      .social-icon:hover { transform: translateY(-3px); box-shadow: 5px 5px 0 #1a1a1a; }

      /* SECTION HEADING */
      .section-heading { font-family: "Syne", sans-serif; font-weight: 800; font-size: clamp(2.2rem,5vw,3.5rem); line-height: 1; letter-spacing: -0.02em; position: relative; display: inline-block; }
      .section-heading .underline-stroke { display: block; height: 5px; background: #ffe44d; border: 2px solid #1a1a1a; margin-top: 6px; }

      /* CONTACT INFO */
      .contact-info-item { border: 2px solid #1a1a1a; padding: 14px 18px; background: #4ecdc4; box-shadow: 4px 4px 0 #1a1a1a; font-family: "DM Mono", monospace; font-size: 0.85rem; }

      /* SUCCESS MSG */
      #form-success { display: none; border: 3px solid #1a1a1a; background: #a8ff78; padding: 14px; font-family: "Syne", sans-serif; font-weight: 700; box-shadow: 4px 4px 0 #1a1a1a; }
    </style>
  </head>

  <body>
    <!-- CUSTOM CURSOR -->
    <div id="cursor"></div>
    <div id="cursor-ring"></div>

    <!-- PROJECT MODAL -->
    <div id="project-modal">
      <div id="modal-content">
        <button id="modal-close" aria-label="Close modal">✕</button>
        <div id="modal-img-wrap"></div>
        <div class="p-6">
          <div id="modal-tags" class="flex flex-wrap gap-1 mb-3"></div>
          <h3 id="modal-title" style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.4rem;"></h3>
          <p id="modal-summary" class="text-sm mt-2" style="color:#555;"></p>
          <div id="modal-description" class="mt-4 text-sm leading-relaxed" style="color:#333;border-top:2px solid #1a1a1a;padding-top:16px;"></div>
          <div id="modal-actions" class="flex gap-3 mt-6"></div>
        </div>
      </div>
    </div>

    <!-- NAVBAR -->
    <nav id="navbar">
      <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-16">
          <a href="#hero" class="font-syne font-extrabold text-xl tracking-tight" style="font-family:'Syne',sans-serif">MR<span style="color:#ff6b6b">Portfolio</span><span style="color:#ffe44d">.</span></a>
          <div class="hidden md:flex items-center gap-8">
            <a href="#about" class="nav-link text-sm font-bold">About</a>
            <a href="#skills" class="nav-link text-sm font-bold">Skills</a>
            <a href="#projects" class="nav-link text-sm font-bold">Projects</a>
            <a href="#contact" class="nav-link text-sm font-bold">Contact</a>
          </div>
          <div class="hidden md:flex items-center gap-3">
            <a href="/login" class="nb-btn nb-btn-dark px-4 py-2 text-sm">LOGIN</a>
          </div>
          <button id="hamburger" class="md:hidden flex flex-col gap-1.5 p-2" aria-label="Menu">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
          </button>
        </div>
      </div>
      <div id="mobile-menu">
        <div class="px-4 py-4 flex flex-col gap-4">
          <a href="#about" class="nav-link font-bold text-sm">About</a>
          <a href="#skills" class="nav-link font-bold text-sm">Skills</a>
          <a href="#projects" class="nav-link font-bold text-sm">Projects</a>
          <a href="#contact" class="nav-link font-bold text-sm">Contact</a>
          <div class="flex gap-3 pt-2">
            <a href="/login" class="nb-btn nb-btn-dark px-4 py-2 text-sm">LOGIN</a>
          </div>
        </div>
      </div>
    </nav>

    @yield('content')

    <!-- FOOTER -->
    <footer style="background:#1a1a1a;border-top:3px solid #ffe44d;padding:40px 24px;">
      <div class="max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
          <div>
            <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.2rem;color:#ffe44d;">MR<span style="color:#ff6b6b">Portfolio</span>.</div>
            <div style="font-family:'DM Mono',monospace;font-size:0.75rem;color:#888;margin-top:4px;">MOCHAMAD MIFTAH RACHMATULLAH</div>
            <div style="font-family:'DM Mono',monospace;font-size:0.7rem;color:#555;margin-top:2px;">&copy; 2026 - ALL RIGHTS RESERVED</div>
          </div>
          <div class="flex gap-3">
            <a href="https://github.com/Miftahrachmatullah" target="_blank" class="social-icon" title="GitHub">
              <img src="https://img.icons8.com/3d-fluency/94/github-logo.png" alt="GitHub" style="width:20px;height:20px" />
            </a>
            <a href="https://www.linkedin.com/in/miftahrachmatullah/" target="_blank" class="social-icon" title="LinkedIn">
              <img src="https://img.icons8.com/ios-filled/50/linkedin-circled--v1.png" alt="LinkedIn" style="width:20px;height:20px" />
            </a>
            <a href="https://www.instagram.com/miftahrachmatullah?igsh=MWY5N2gxY3hvbGp1bQ==" target="_blank" class="social-icon" title="Instagram">
              <img src="https://img.icons8.com/ios-glyphs/30/instagram-circle.png" alt="Instagram" style="width:20px;height:20px" />
            </a>
          </div>
        </div>
        <div style="border-top:1px solid #333;margin-top:24px;padding-top:20px;text-align:center;">
          <div class="flex flex-wrap justify-center gap-6" style="font-family:'DM Mono',monospace;font-size:0.75rem;color:#555;">
            <a href="#about" style="color:#888;text-decoration:none" class="nav-link">ABOUT</a>
            <a href="#skills" style="color:#888;text-decoration:none" class="nav-link">SKILLS</a>
            <a href="#projects" style="color:#888;text-decoration:none" class="nav-link">PROJECTS</a>
            <a href="#contact" style="color:#888;text-decoration:none" class="nav-link">CONTACT</a>
          </div>
        </div>
      </div>
    </footer>

    <script>
      // === CURSOR ===
      const cursor = document.getElementById("cursor");
      const ring = document.getElementById("cursor-ring");
      let mx = 0, my = 0, rx = 0, ry = 0;
      document.addEventListener("mousemove", (e) => {
        mx = e.clientX; my = e.clientY;
        cursor.style.left = mx - 6 + "px";
        cursor.style.top = my - 6 + "px";
      });
      function animRing() {
        rx += (mx - rx - 16) * 0.12;
        ry += (my - ry - 16) * 0.12;
        ring.style.left = rx + "px";
        ring.style.top = ry + "px";
        requestAnimationFrame(animRing);
      }
      animRing();
      document.querySelectorAll("a,button,.nb-card,.skill-badge").forEach((el) => {
        el.addEventListener("mouseenter", () => { ring.style.transform = "scale(1.5)"; ring.style.borderColor = "#FF6B6B"; });
        el.addEventListener("mouseleave", () => { ring.style.transform = "scale(1)"; ring.style.borderColor = "#1a1a1a"; });
      });

      // === NAVBAR SCROLL ===
      const navbar = document.getElementById("navbar");
      const mobileMenu = document.getElementById("mobile-menu");
      window.addEventListener("scroll", () => {
        if (window.scrollY > 80) { navbar.classList.add("scrolled"); if (mobileMenu.classList.contains("open")) mobileMenu.classList.add("scrolled"); }
        else { navbar.classList.remove("scrolled"); mobileMenu.classList.remove("scrolled"); }
      });

      // === HAMBURGER ===
      const ham = document.getElementById("hamburger");
      const lines = ham.querySelectorAll(".hamburger-line");
      ham.addEventListener("click", () => {
        mobileMenu.classList.toggle("open");
        if (mobileMenu.classList.contains("open")) {
          lines[0].style.transform = "translateY(7.5px) rotate(45deg)";
          lines[1].style.opacity = "0";
          lines[2].style.transform = "translateY(-7.5px) rotate(-45deg)";
        } else {
          lines[0].style.transform = ""; lines[1].style.opacity = ""; lines[2].style.transform = "";
        }
      });
      document.querySelectorAll("#mobile-menu a").forEach((a) => a.addEventListener("click", () => {
        mobileMenu.classList.remove("open");
        lines[0].style.transform = ""; lines[1].style.opacity = ""; lines[2].style.transform = "";
      }));

      // === SCRAMBLE TEXT ===
      const target = "MOCHAMAD MIFTAH RACHMATULLAH";
      const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%&*";
      const el = document.getElementById("scramble-text");
      if (el) {
        el.style.opacity = 1;
        let iter = 0;
        const scram = setInterval(() => {
          el.innerText = target.split("").map((c, i) => { if (i < iter) return target[i]; return c === " " ? " " : chars[Math.floor(Math.random() * chars.length)]; }).join("");
          if (iter >= target.length) clearInterval(scram);
          iter += 1.5;
        }, 50);
      }

      // === TYPEWRITER ===
      const texts = ["Fullstack Developer", "UI/UX Designer", "IT Support"];
      let ti = 0, ci = 0, del = false;
      const tw = document.getElementById("typewriter");
      if (tw) {
        function type() {
          const cur = texts[ti];
          if (!del) { tw.textContent = cur.slice(0, ci + 1); ci++; if (ci === cur.length) { del = true; setTimeout(type, 1500); return; } }
          else { tw.textContent = cur.slice(0, ci - 1); ci--; if (ci === 0) { del = false; ti = (ti + 1) % texts.length; } }
          setTimeout(type, del ? 60 : 100);
        }
        setTimeout(type, 1800);
      }

      // === INTERSECTION OBSERVER for reveals ===
      const revealEls = document.querySelectorAll(".reveal");
      const revObs = new IntersectionObserver((entries) => {
        entries.forEach((e) => { if (e.isIntersecting) { e.target.classList.add("visible"); revObs.unobserve(e.target); } });
      }, { threshold: 0.12 });
      revealEls.forEach((el) => revObs.observe(el));

      // === COUNT UP ANIMATION ===
      const statEls = document.querySelectorAll(".stat-num[data-target]");
      const statObs = new IntersectionObserver((entries) => {
        entries.forEach((e) => {
          if (e.isIntersecting) {
            const t = parseInt(e.target.dataset.target);
            let c = 0;
            const step = Math.max(1, Math.floor(t / 30));
            const int = setInterval(() => { c += step; if (c >= t) { c = t; clearInterval(int); } e.target.textContent = c; }, 40);
            statObs.unobserve(e.target);
          }
        });
      }, { threshold: 0.5 });
      statEls.forEach((el) => statObs.observe(el));

      // === CONTACT FORM → open mailto ===
      const contactForm = document.getElementById("contact-form");
      if (contactForm) {
        contactForm.addEventListener("submit", function (e) {
          e.preventDefault();
          const name = document.getElementById("fname").value;
          const email = document.getElementById("femail").value;
          const msg = document.getElementById("fmsg").value;
          const subject = encodeURIComponent(`Portfolio Contact from ${name}`);
          const body = encodeURIComponent(`Nama: ${name}\nEmail: ${email}\n\nPesan:\n${msg}`);
          window.open(`mailto:mochamadmiftah34@gmail.com?subject=${subject}&body=${body}`, "_blank");
          const succ = document.getElementById("form-success");
          succ.style.display = "block";
          this.reset();
          setTimeout(() => { succ.style.display = "none"; }, 4000);
        });
      }

      // === BUTTON PRESS PHYSICS ===
      document.querySelectorAll(".nb-btn").forEach((btn) => {
        btn.addEventListener("mousedown", () => { btn.style.transform = "translateY(3px)"; });
        btn.addEventListener("mouseup", () => { btn.style.transform = ""; });
        btn.addEventListener("mouseleave", () => { btn.style.transform = ""; });
      });

      // === PROJECT FILTER ===
      const filterBtns = document.querySelectorAll(".filter-btn");
      const projectCards = document.querySelectorAll(".project-card");
      filterBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
          filterBtns.forEach((b) => b.classList.remove("active"));
          btn.classList.add("active");
          const filter = btn.dataset.filter;
          projectCards.forEach((card) => {
            const cats = card.dataset.categories || "";
            if (filter === "all" || cats.toLowerCase().includes(filter.toLowerCase())) {
              card.style.display = "";
            } else {
              card.style.display = "none";
            }
          });
        });
      });

      // === PROJECT MODAL ===
      const modal = document.getElementById("project-modal");
      const modalClose = document.getElementById("modal-close");
      document.querySelectorAll(".open-modal-btn").forEach((btn) => {
        btn.addEventListener("click", () => {
          const card = btn.closest(".project-card");
          document.getElementById("modal-title").textContent = card.dataset.title || "";
          document.getElementById("modal-summary").textContent = card.dataset.summary || "";
          document.getElementById("modal-description").textContent = card.dataset.description || "";
          const demoUrl = card.dataset.demoUrl || "";
          const imgSrc = card.dataset.img || "";
          const tags = (card.dataset.technologies || "").split(",").filter(Boolean);

          // Modal image
          const imgWrap = document.getElementById("modal-img-wrap");
          if (imgSrc) {
            imgWrap.innerHTML = `<img src="${imgSrc}" alt="Project Image" style="width:100%;height:220px;object-fit:cover;border-bottom:3px solid #1a1a1a;">`;
          } else {
            imgWrap.innerHTML = `<div style="width:100%;height:180px;background:#ffe44d;border-bottom:3px solid #1a1a1a;display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-weight:800;font-size:1.3rem;">${card.dataset.title}</div>`;
          }

          // Modal tags
          const tagsEl = document.getElementById("modal-tags");
          tagsEl.innerHTML = tags.map(t => `<span class="tag-pill">${t.trim()}</span>`).join("");

          // Modal actions
          const actionsEl = document.getElementById("modal-actions");
          if (demoUrl && demoUrl !== "#") {
            actionsEl.innerHTML = `<a href="${demoUrl}" target="_blank" class="nb-btn nb-btn-yellow px-6 py-3 text-sm">VIEW LIVE DEMO ↗</a>`;
          } else {
            actionsEl.innerHTML = `<span style="font-family:'DM Mono',monospace;font-size:0.8rem;color:#888;border:2px dashed #ccc;padding:10px 16px;">Demo not available</span>`;
          }

          modal.classList.add("open");
          document.body.style.overflow = "hidden";
        });
      });
      modalClose.addEventListener("click", () => { modal.classList.remove("open"); document.body.style.overflow = ""; });
      modal.addEventListener("click", (e) => { if (e.target === modal) { modal.classList.remove("open"); document.body.style.overflow = ""; } });
    </script>
  </body>
</html>