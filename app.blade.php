<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Hogwarts Academy') — Sistem Informasi Sekolah</title>

    {{-- Fonts: Cinzel (ala Harry Potter) & Cormorant --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Cormorant+Garamond:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Tailwind via CDN (opsional, bisa dihapus jika pakai Vite) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --hp-gold:      #d4af37;
            --hp-gold-soft: #c9a227;
            --hp-dark:      #0f0e0a;
            --hp-brown:     #1e1a14;
            --hp-parch:     #f4e9d0;
            --hp-crimson:   #7a1010;
            --hp-green:     #14532d;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Cormorant Garamond', serif;
            background-color: var(--hp-dark);
            color: var(--hp-parch);
            min-height: 100vh;
            /* Tekstur bintang / parchment gelap */
            background-image:
                radial-gradient(ellipse at top, rgba(212,175,55,0.08), transparent 60%),
                radial-gradient(ellipse at bottom, rgba(122,16,16,0.10), transparent 60%),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cg fill='%23d4af37' fill-opacity='0.05'%3E%3Cpath d='M50 50c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10-10-4.477-10-10zM10 10c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10S10 15.523 10 10z'/%3E%3C/g%3E%3C/svg%3E");
            background-attachment: fixed;
        }

        h1, h2, h3, h4, h5, h6, .font-magic {
            font-family: 'Cinzel', serif;
            letter-spacing: 0.03em;
        }

        /* ============ SIDEBAR ============ */
        .hp-sidebar {
            background:
                linear-gradient(180deg, rgba(30,26,20,0.98) 0%, rgba(15,14,10,0.98) 100%);
            border-right: 2px solid var(--hp-gold);
            box-shadow: 4px 0 24px rgba(0,0,0,0.6), inset -1px 0 0 rgba(212,175,55,0.15);
            position: relative;
        }
        .hp-sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                repeating-linear-gradient(0deg, transparent 0 3px, rgba(212,175,55,0.02) 3px 4px);
            pointer-events: none;
        }

        .hp-brand {
            border-bottom: 1px solid rgba(212,175,55,0.25);
            padding: 1.5rem 1rem;
            text-align: center;
        }
        .hp-crest {
            font-size: 2.5rem;
            filter: drop-shadow(0 0 12px rgba(212,175,55,0.6));
            animation: crestGlow 3s ease-in-out infinite alternate;
        }
        @keyframes crestGlow {
            from { filter: drop-shadow(0 0 8px rgba(212,175,55,0.4)); }
            to   { filter: drop-shadow(0 0 18px rgba(212,175,55,0.9)); }
        }
        .hp-brand-title {
            font-family: 'Cinzel', serif;
            font-weight: 700;
            color: var(--hp-gold);
            font-size: 1.15rem;
            margin-top: 0.5rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
        }
        .hp-brand-sub {
            font-size: 0.75rem;
            color: rgba(244,233,208,0.5);
            letter-spacing: 0.2em;
            text-transform: uppercase;
        }

        /* ============ NAV LINK ============ */
        .hp-nav-link {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.7rem 1rem;
            margin: 0.15rem 0.5rem;
            border-radius: 8px;
            color: rgba(244,233,208,0.75);
            font-family: 'Cinzel', serif;
            font-size: 0.82rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            text-decoration: none;
            transition: all 0.25s ease;
            border-left: 3px solid transparent;
        }
        .hp-nav-link i { font-size: 1.05rem; color: var(--hp-gold-soft); }
        .hp-nav-link:hover {
            color: var(--hp-parch);
            background: linear-gradient(90deg, rgba(212,175,55,0.15), transparent);
            border-left-color: var(--hp-gold);
        }
        .hp-nav-link.active {
            color: var(--hp-gold);
            background: linear-gradient(90deg, rgba(212,175,55,0.22), rgba(212,175,55,0.03));
            border-left-color: var(--hp-gold);
            box-shadow: inset 0 0 20px rgba(212,175,55,0.08);
        }

        .hp-nav-section {
            padding: 1rem 1rem 0.25rem;
            font-size: 0.65rem;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: rgba(212,175,55,0.5);
            font-family: 'Cinzel', serif;
        }

        /* ============ MAIN AREA ============ */
        .hp-main {
            flex: 1;
            min-height: 100vh;
        }

        .hp-topbar {
            background: linear-gradient(90deg, rgba(30,26,20,0.95), rgba(15,14,10,0.85));
            border-bottom: 1px solid rgba(212,175,55,0.3);
            backdrop-filter: blur(8px);
            padding: 0.9rem 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 30;
        }

        .hp-page-title {
            font-family: 'Cinzel', serif;
            font-size: 1.35rem;
            color: var(--hp-gold);
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        /* ============ CONTENT WRAPPER ============ */
        .hp-content {
            padding: 2rem 2rem 3rem;
            max-width: 1400px;
            margin: 0 auto;
            animation: fadeUp 0.4s ease-out;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ============ CARD ============ */
        .hp-card {
            background: linear-gradient(145deg, rgba(30,26,20,0.9), rgba(20,17,12,0.95));
            border: 1px solid rgba(212,175,55,0.35);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow:
                0 8px 30px rgba(0,0,0,0.5),
                inset 0 1px 0 rgba(212,175,55,0.1);
            position: relative;
            overflow: hidden;
        }
        .hp-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--hp-gold), transparent);
            opacity: 0.6;
        }

        /* ============ BUTTON ============ */
        .hp-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.55rem 1.1rem;
            border-radius: 8px;
            font-family: 'Cinzel', serif;
            font-size: 0.78rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            text-decoration: none;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.25s ease;
        }
        .hp-btn-gold {
            background: linear-gradient(135deg, #d4af37, #b8860b);
            color: #1a1410;
            border-color: #e6c865;
            font-weight: 700;
            box-shadow: 0 4px 14px rgba(212,175,55,0.3);
        }
        .hp-btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212,175,55,0.5);
        }
        .hp-btn-outline {
            background: transparent;
            color: var(--hp-gold);
            border-color: rgba(212,175,55,0.5);
        }
        .hp-btn-outline:hover {
            background: rgba(212,175,55,0.1);
            border-color: var(--hp-gold);
        }
        .hp-btn-danger {
            background: linear-gradient(135deg, #7a1010, #4a0a0a);
            color: #f4d0d0;
            border-color: rgba(200,60,60,0.5);
        }
        .hp-btn-danger:hover {
            background: linear-gradient(135deg, #9a1a1a, #5a0f0f);
        }

        /* ============ TABLE ============ */
        .hp-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 6px;
        }
        .hp-table thead th {
            font-family: 'Cinzel', serif;
            font-size: 0.72rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--hp-gold);
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(212,175,55,0.3);
        }
        .hp-table tbody tr {
            background: rgba(30,26,20,0.6);
            transition: all 0.2s;
        }
        .hp-table tbody tr:hover {
            background: rgba(212,175,55,0.08);
            transform: scale(1.005);
        }
        .hp-table tbody td {
            padding: 0.85rem 1rem;
            font-size: 0.95rem;
            color: rgba(244,233,208,0.9);
            border-top: 1px solid rgba(212,175,55,0.08);
        }
        .hp-table tbody td:first-child {
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }
        .hp-table tbody td:last-child {
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        /* ============ FORM INPUT ============ */
        .hp-input,
        .hp-select,
        .hp-textarea {
            width: 100%;
            background: rgba(15,14,10,0.6);
            border: 1px solid rgba(212,175,55,0.3);
            border-radius: 8px;
            padding: 0.65rem 1rem;
            color: var(--hp-parch);
            font-family: 'Cormorant Garamond', serif;
            font-size: 1rem;
            transition: all 0.25s;
        }
        .hp-input:focus,
        .hp-select:focus,
        .hp-textarea:focus {
            outline: none;
            border-color: var(--hp-gold);
            box-shadow: 0 0 0 3px rgba(212,175,55,0.15);
            background: rgba(15,14,10,0.85);
        }
        .hp-input::placeholder { color: rgba(244,233,208,0.35); }
        .hp-label {
            display: block;
            font-family: 'Cinzel', serif;
            font-size: 0.72rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--hp-gold-soft);
            margin-bottom: 0.4rem;
        }

        /* ============ BADGE ============ */
        .hp-badge {
            display: inline-block;
            padding: 0.2rem 0.7rem;
            border-radius: 999px;
            font-family: 'Cinzel', serif;
            font-size: 0.7rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            border: 1px solid;
        }
        .hp-badge-gold { color: var(--hp-gold); border-color: var(--hp-gold); background: rgba(212,175,55,0.1); }
        .hp-badge-green { color: #6ee7a6; border-color: #14532d; background: rgba(20,83,45,0.4); }
        .hp-badge-red { color: #fca5a5; border-color: #7a1010; background: rgba(122,16,16,0.3); }

        /* ============ ALERT ============ */
        .hp-alert {
            border-radius: 10px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            border: 1px solid;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .hp-alert-success {
            background: rgba(20,83,45,0.25);
            border-color: rgba(110,231,166,0.5);
            color: #a7f3d0;
        }
        .hp-alert-error {
            background: rgba(122,16,16,0.25);
            border-color: rgba(252,165,165,0.5);
            color: #fecaca;
        }

        /* ============ SCROLLBAR ============ */
        ::-webkit-scrollbar { width: 10px; height: 10px; }
        ::-webkit-scrollbar-track { background: var(--hp-dark); }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #b8860b, #6b4f08);
            border-radius: 6px;
        }
        ::-webkit-scrollbar-thumb:hover { background: var(--hp-gold); }

        /* ============ MOBILE ============ */
        #hp-sidebar-toggle:checked ~ .hp-sidebar-backdrop { display: block; }
        #hp-sidebar-toggle:checked ~ aside { transform: translateX(0); }
        @media (max-width: 1024px) {
            .hp-sidebar {
                position: fixed;
                top: 0; left: 0; bottom: 0;
                width: 280px;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 60;
            }
            .hp-sidebar-backdrop {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.7);
                z-index: 50;
            }
        }
    </style>
</head>
<body>

{{-- Hidden checkbox untuk toggle sidebar mobile --}}
<input type="checkbox" id="hp-sidebar-toggle" class="hidden">

<div class="flex min-h-screen">

    {{-- ================= SIDEBAR ================= --}}
    <aside class="hp-sidebar w-64 flex-shrink-0 flex flex-col">
        <div class="hp-brand">
            <div class="hp-crest">🦅</div>
            <div class="hp-brand-title">Hogwarts</div>
            <div class="hp-brand-sub">Academy</div>
        </div>

            <div class="hp-nav-section">Data Akademik</div>
            <a href="{{ route('kelas.index') }}"
               class="hp-nav-link {{ request()->routeIs('kelas.*') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i> Kelas
            </a>
            <a href="{{ route('siswa.index') }}"
               class="hp-nav-link {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i> Siswa
            </a>
            <a href="{{ route('guru.index') }}"
               class="hp-nav-link {{ request()->routeIs('guru.*') ? 'active' : '' }}">
                <i class="bi bi-person-workspace"></i> Guru
            </a>

            <div class="hp-nav-section">Kurikulum</div>
            <a href="{{ route('mata-pelajaran.index') }}"
               class="hp-nav-link {{ request()->routeIs('mata-pelajaran.*') ? 'active' : '' }}">
                <i class="bi bi-book"></i> Mata Pelajaran
            </a>
            <a href="{{ route('mapel-guru.index') }}"
               class="hp-nav-link {{ request()->routeIs('mapel-guru.*') ? 'active' : '' }}">
                <i class="bi bi-diagram-3"></i> Mapel Guru
            </a>

            <div class="hp-nav-section">Penilaian</div>
            <a href="{{ route('nilai.index') }}"
               class="hp-nav-link {{ request()->routeIs('nilai.*') ? 'active' : '' }}">
                <i class="bi bi-journal-check"></i> Nilai
            </a>
        </nav>

        {{-- Footer sidebar --}}
        <div class="p-4 border-t border-yellow-700/30">
            <div class="text-xs text-yellow-600/60 font-magic tracking-widest text-center">
                ✦ Draco Dormiens Nunquam Titillandus ✦
            </div>
        </div>
    </aside>

    {{-- Backdrop mobile --}}
    <div class="hp-sidebar-backdrop lg:hidden"></div>

    {{-- ================= MAIN ================= --}}
    <div class="hp-main flex flex-col">

        {{-- Topbar --}}
        <header class="hp-topbar">
            <div class="flex items-center gap-4">
                {{-- Tombol hamburger (mobile) --}}
                <label for="hp-sidebar-toggle"
                       class="lg:hidden cursor-pointer text-yellow-500 text-2xl hover:text-yellow-300">
                    <i class="bi bi-list"></i>
                </label>
                <h1 class="hp-page-title">@yield('title', 'Dashboard')</h1>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden md:flex items-center gap-2 text-sm text-yellow-600/80 font-magic tracking-wider">
                    <i class="bi bi-calendar3"></i>
                    {{ now()->translatedFormat('d F Y') }}
                </div>
                <div class="flex items-center gap-2 pl-4 border-l border-yellow-700/40">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-yellow-500 to-yellow-800 flex items-center justify-center text-black font-bold font-magic">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="hidden sm:block">
                        <div class="text-sm text-yellow-200 font-magic">{{ auth()->user()->name ?? 'Administrator' }}</div>
                        <div class="text-xs text-yellow-600/60">Headmaster</div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Flash Message --}}
        <div class="px-8 pt-6">
            @if(session('success'))
                <div class="hp-alert hp-alert-success">
                    <i class="bi bi-check-circle-fill text-xl"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="hp-alert hp-alert-error">
                    <i class="bi bi-exclamation-triangle-fill text-xl"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
        </div>

        {{-- Content --}}
        <main class="hp-content flex-1">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="text-center py-4 text-xs text-yellow-700/50 font-magic tracking-widest border-t border-yellow-700/20">
            ✦ Hogwarts School of Witchcraft and Wizardry &middot; Est. 990 A.D. ✦
        </footer>
    </div>
</div>

</body>
</html>