<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Admin Login — MR Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&family=Space+Mono:wght@400;700&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: #FFFDF0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-y: auto;
        }

        /* dot grid background */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: radial-gradient(#1A1A1A 1.5px, transparent 1.5px);
            background-size: 24px 24px;
            opacity: 0.08;
            pointer-events: none;
            z-index: 0;
        }

        /* Floating deco elements */
        .deco-box {
            position: fixed;
            border: 3px solid #1a1a1a;
            z-index: 0;
            animation: floatBox 4s ease-in-out infinite;
        }
        @keyframes floatBox {
            0%,100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-14px) rotate(6deg); }
        }
        @keyframes floatCircle {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .login-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 520px;
            background: #fff;
            border: 3px solid #1A1A1A;
            box-shadow: 10px 10px 0px #1A1A1A;
            margin: 24px;
        }

        .card-header {
            background: #FFE44D;
            border-bottom: 3px solid #1A1A1A;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .card-dot { width: 12px; height: 12px; border: 1px solid #1A1A1A; display: inline-block; }

        .card-body { padding: 32px; display: flex; flex-direction: column; gap: 24px; }

        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-label {
            font-family: 'Syne', sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #1a1a1a;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .form-label .material-symbols-outlined { font-size: 16px; }

        .form-input-wrap { position: relative; }
        .form-input-wrap .material-symbols-outlined.icon-left {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #555;
            pointer-events: none;
        }
        .form-input {
            width: 100%;
            height: 48px;
            padding: 0 16px 0 44px;
            font-family: 'Space Mono', monospace;
            font-size: 13px;
            background: #FFFDF0;
            border: 2px solid #1A1A1A;
            box-shadow: 3px 3px 0 #1A1A1A;
            outline: none;
            color: #1a1a1a;
            transition: all 0.15s;
        }
        .form-input::placeholder { color: #aaa; }
        .form-input:focus {
            box-shadow: 5px 5px 0 #1A1A1A;
            transform: translate(-2px, -2px);
        }
        .form-input.error { border-color: #FF6B6B; box-shadow: 3px 3px 0 #FF6B6B; }

        .pass-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #555;
            display: flex;
            align-items: center;
            gap: 4px;
            font-family: 'Space Mono', monospace;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .pass-toggle .material-symbols-outlined { font-size: 16px; }

        .error-banner {
            display: none;
            background: #FFF2F2;
            border: 2px solid #FF6B6B;
            padding: 12px 16px;
            box-shadow: 3px 3px 0 #FF6B6B;
            gap: 8px;
            align-items: flex-start;
        }
        .error-banner.show { display: flex; }
        .error-banner .material-symbols-outlined { font-size: 20px; color: #FF6B6B; flex-shrink: 0; margin-top: 1px; }
        .error-banner-text { font-family: 'Space Grotesk', sans-serif; font-size: 13px; color: #1a1a1a; }
        .error-banner-title { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 12px; text-transform: uppercase; }

        .btn-submit {
            width: 100%;
            height: 52px;
            background: #FFE44D;
            border: 3px solid #1A1A1A;
            box-shadow: 5px 5px 0 #1A1A1A;
            font-family: 'Syne', sans-serif;
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #1a1a1a;
            cursor: pointer;
            transition: all 0.12s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn-submit:hover { transform: translate(-2px, -2px); box-shadow: 7px 7px 0 #1A1A1A; }
        .btn-submit:active { transform: translate(2px, 2px); box-shadow: 1px 1px 0 #1A1A1A; }
        .btn-submit.loading { opacity: 0.75; pointer-events: none; background: #4ECDC4; }
        .btn-submit .material-symbols-outlined { font-size: 20px; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .spin { animation: spin 0.8s linear infinite; }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-family: 'Syne', sans-serif;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #1a1a1a;
            text-decoration: none;
            border: 2px solid #1A1A1A;
            padding: 8px 16px;
            box-shadow: 3px 3px 0 #1A1A1A;
            transition: all 0.12s;
        }
        .back-link:hover { transform: translate(-2px, -2px); box-shadow: 5px 5px 0 #1A1A1A; }
        .back-link .material-symbols-outlined { font-size: 16px; }

        .card-footer {
            background: #F5F5F5;
            border-top: 3px solid #1A1A1A;
            padding: 14px 20px;
            text-align: center;
            font-family: 'Space Mono', monospace;
            font-size: 11px;
            color: #666;
        }
        .card-footer strong { color: #FF6B6B; }

        .title-section { border-bottom: 3px solid #1A1A1A; padding-bottom: 20px; }
        .title-section h1 {
            font-family: 'Syne', sans-serif;
            font-size: 28px;
            font-weight: 800;
            text-transform: uppercase;
            line-height: 1.1;
            margin-top: 8px;
        }
        .title-section p { font-size: 13px; color: #666; margin-top: 6px; }

        .divider { border: none; border-top: 2px dashed #1A1A1A; }
    </style>
</head>
<body>
    <!-- Decorative elements -->
    <div class="deco-box" style="width:50px;height:50px;top:8%;left:6%;background:#FFE44D;animation-delay:0s;"></div>
    <div class="deco-box" style="width:30px;height:30px;bottom:12%;left:8%;background:#FF6B6B;animation-delay:1s;"></div>
    <div class="deco-box" style="width:40px;height:40px;top:15%;right:7%;background:#A8FF78;animation-delay:0.5s;"></div>
    <div class="deco-box" style="width:22px;height:22px;bottom:20%;right:10%;background:#4ECDC4;animation-delay:1.5s;"></div>

    <div class="login-card">
        <!-- Card header bar -->
        <div class="card-header">
            <span class="card-dot" style="background:#FF6B6B;"></span>
            <span class="card-dot" style="background:#FFE44D;"></span>
            <span class="card-dot" style="background:#A8FF78;"></span>
            <span style="font-family:'Space Mono',monospace;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin-left:8px;">PORTAL ADMIN — MR PORTFOLIO</span>
        </div>

        <div class="card-body">
            <!-- Title -->
            <div class="title-section">
                <h1>Masuk ke<br>Dashboard</h1>
                <p>Area akses terbatas. Masukkan kredensial administratif Anda.</p>
            </div>

            <!-- Error banner (Laravel validation errors) -->
            @if ($errors->any())
            <div class="error-banner show">
                <span class="material-symbols-outlined">error</span>
                <div>
                    <div class="error-banner-title">Autentikasi Gagal</div>
                    @foreach ($errors->all() as $error)
                    <div class="error-banner-text">{{ $error }}</div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- JS error banner (for UX states) -->
            <div class="error-banner" id="js-error-banner">
                <span class="material-symbols-outlined">error</span>
                <div>
                    <div class="error-banner-title">Autentikasi Gagal</div>
                    <div class="error-banner-text" id="js-error-text">Email atau kata sandi tidak cocok.</div>
                </div>
            </div>

            <!-- Login Form -->
            <form id="login-form" action="{{ route('login.post') }}" method="POST">
                @csrf

                <div class="form-group" style="margin-bottom:16px;">
                    <label class="form-label" for="email">
                        <span class="material-symbols-outlined">alternate_email</span> Email
                    </label>
                    <div class="form-input-wrap">
                        <span class="material-symbols-outlined icon-left">alternate_email</span>
                        <input
                            class="form-input {{ $errors->has('email') ? 'error' : '' }}"
                            id="email"
                            name="email"
                            autocomplete="username"
                            type="email"
                            placeholder="admin@example.com"
                            value="{{ old('email') }}"
                            required
                            autofocus
                        >
                    </div>
                </div>

                <div class="form-group" style="margin-bottom:20px;">
                    <label class="form-label" for="password">
                        <span class="material-symbols-outlined">key</span> Kata Sandi
                    </label>
                    <div class="form-input-wrap">
                        <span class="material-symbols-outlined icon-left">key</span>
                        <input
                            class="form-input {{ $errors->has('email') ? 'error' : '' }}"
                            id="password"
                            name="password"
                            autocomplete="current-password"
                            type="password"
                            placeholder="••••••••••"
                            required
                        >
                        <button type="button" class="pass-toggle" id="pass-toggle" aria-label="Tampilkan atau sembunyikan password">
                            <span class="material-symbols-outlined" id="eye-icon">visibility</span>
                            <span id="eye-label">Lihat</span>
                        </button>
                    </div>
                </div>

                <button class="btn-submit" id="btn-submit" type="submit">
                    <span id="btn-text">Masuk ke Dashboard</span>
                    <span class="material-symbols-outlined" id="btn-icon">arrow_forward</span>
                </button>
            </form>

            <hr class="divider">

            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
                <a href="/" class="back-link">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Kembali ke Beranda
                </a>
                <span style="font-family:'Space Mono',monospace;font-size:10px;color:#999;">v1.0.0</span>
            </div>
        </div>

        <div class="card-footer">
            <strong>[ PERINGATAN SISTEM ]</strong> Area akses terbatas. Hanya untuk pemilik MRPortfolio.
        </div>
    </div>

    <script nonce="{{ Vite::cspNonce() }}">
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            const label = document.getElementById('eye-label');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility_off';
                label.textContent = 'Tutup';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility';
                label.textContent = 'Lihat';
            }
        }

        document.getElementById('pass-toggle').addEventListener('click', togglePassword);

        document.getElementById('login-form').addEventListener('submit', function() {
            const btn = document.getElementById('btn-submit');
            const text = document.getElementById('btn-text');
            const icon = document.getElementById('btn-icon');
            btn.classList.add('loading');
            text.textContent = 'Memverifikasi...';
            icon.textContent = 'sync';
            icon.classList.add('spin');
        });
    </script>
</body>
</html>
