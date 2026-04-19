<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin - Pengaduan Siswa</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.4/dist/tailwind.min.css">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Syne:wght@600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --teal: #0d7377;
            --teal-light: rgba(13,115,119,0.08);
            --teal-mid: rgba(13,115,119,0.15);
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --text-tertiary: #9ca3af;
            --bg-primary: #ffffff;
            --bg-secondary: #f9fafb;
            --bg-tertiary: #f3f4f6;
            --border: rgba(0,0,0,0.07);
            --border-md: rgba(0,0,0,0.12);
            --radius-md: 8px;
            --radius-lg: 12px;
            --radius-xl: 16px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg-tertiary);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed;
            left: 0; top: 0;
            width: 220px;
            height: 100vh;
            background: var(--bg-primary);
            border-right: 0.5px solid var(--border);
            display: flex;
            flex-direction: column;
            padding: 24px 0;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 0 20px 20px;
            border-bottom: 0.5px solid var(--border);
            margin-bottom: 16px;
        }

        .brand-mark {
            width: 36px; height: 36px;
            background: var(--teal);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 10px;
        }

        .brand-mark svg { width: 18px; height: 18px; fill: white; }

        .brand-name {
            font-family: 'Syne', sans-serif;
            font-size: 13px; font-weight: 700;
            color: var(--text-primary);
            line-height: 1.3;
        }

        .brand-sub {
            font-size: 11px;
            color: var(--text-secondary);
            margin-top: 1px;
        }

        .nav-label {
            font-size: 10px; font-weight: 600;
            color: var(--text-tertiary);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 0 20px;
            margin-bottom: 4px;
        }

        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 20px;
            font-size: 13px; font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            border-left: 2px solid transparent;
            transition: all 0.15s;
        }

        .nav-item:hover {
            color: var(--text-primary);
            background: var(--bg-secondary);
        }

        .nav-item.active {
            color: var(--teal);
            background: var(--teal-light);
            border-left-color: var(--teal);
            font-weight: 600;
        }

        .nav-item svg { width: 15px; height: 15px; flex-shrink: 0; }

        .nav-badge {
            margin-left: auto;
            font-size: 10px; font-weight: 600;
            background: #fef3c7; color: #d97706;
            padding: 2px 7px; border-radius: 10px;
        }

        .nav-divider {
            height: 0.5px;
            background: var(--border);
            margin: 12px 0;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding: 16px 20px 0;
            border-top: 0.5px solid var(--border);
        }

        .user-chip {
            display: flex; align-items: center; gap: 10px;
        }

        .user-avatar {
            width: 32px; height: 32px;
            background: var(--teal);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 600; color: white;
            flex-shrink: 0;
        }

        .user-info { flex: 1; min-width: 0; }

        .user-name {
            font-size: 12px; font-weight: 600;
            color: var(--text-primary);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        .user-role { font-size: 10px; color: var(--teal); font-weight: 500; }

        .logout-btn {
            width: 28px; height: 28px;
            background: var(--bg-secondary);
            border: 0.5px solid var(--border-md);
            border-radius: var(--radius-md);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; flex-shrink: 0;
            transition: background 0.15s;
        }

        .logout-btn:hover { background: #fee2e2; border-color: #fca5a5; }
        .logout-btn svg { width: 13px; height: 13px; color: var(--text-secondary); }
        .logout-btn:hover svg { color: #dc2626; }

        /* ── MAIN ── */
        .main {
            margin-left: 220px;
            padding: 28px;
            flex: 1;
            min-height: 100vh;
        }

        /* ── TOPBAR ── */
        .topbar {
            display: flex; justify-content: space-between; align-items: flex-start;
            margin-bottom: 24px;
        }

        .page-title {
            font-family: 'Syne', sans-serif;
            font-size: 22px; font-weight: 700;
            color: var(--text-primary); line-height: 1.2;
        }

        .page-sub {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 3px;
        }

        .date-chip {
            display: flex; align-items: center; gap: 6px;
            background: var(--bg-primary);
            border: 0.5px solid var(--border-md);
            border-radius: var(--radius-md);
            padding: 7px 12px;
            font-size: 12px;
            color: var(--text-secondary);
        }

        .date-chip svg { width: 13px; height: 13px; }

        /* ── STATS ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .stat {
            background: var(--bg-primary);
            border: 0.5px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 18px 20px;
        }

        .stat-top {
            display: flex; justify-content: space-between; align-items: flex-start;
            margin-bottom: 14px;
        }

        .stat-icon {
            width: 34px; height: 34px;
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
        }

        .stat-icon svg { width: 16px; height: 16px; }
        .stat-icon.teal  { background: var(--teal-light); color: var(--teal); }
        .stat-icon.amber { background: #fef3c7; color: #d97706; }
        .stat-icon.blue  { background: #dbeafe; color: #2563eb; }
        .stat-icon.green { background: #d1fae5; color: #059669; }

        .stat-trend {
            font-size: 10px; font-weight: 600;
            padding: 2px 6px; border-radius: 6px;
            color: #059669; background: #d1fae5;
        }

        .stat-num {
            font-family: 'Syne', sans-serif;
            font-size: 28px; font-weight: 700;
            color: var(--text-primary);
            line-height: 1; margin-bottom: 4px;
        }

        .stat-num.amber { color: #d97706; }
        .stat-num.blue  { color: #2563eb; }
        .stat-num.green { color: #059669; }
        .stat-label { font-size: 12px; color: var(--text-secondary); }

        /* ── CONTENT GRID ── */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 16px;
        }

        /* ── CARD ── */
        .card {
            background: var(--bg-primary);
            border: 0.5px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
        }

        .card-head {
            display: flex; justify-content: space-between; align-items: center;
            padding: 16px 20px;
            border-bottom: 0.5px solid var(--border);
        }

        .card-title {
            font-size: 14px; font-weight: 600;
            color: var(--text-primary);
            display: flex; align-items: center; gap: 7px;
        }

        .card-title svg { width: 14px; height: 14px; color: var(--text-secondary); }

        .card-action {
            font-size: 12px; color: var(--teal); font-weight: 500;
            text-decoration: none;
        }

        .card-action:hover { text-decoration: underline; }

        /* ── COMPLAINT LIST ── */
        .complaint-item {
            display: flex; align-items: flex-start; gap: 12px;
            padding: 14px 20px;
            border-bottom: 0.5px solid var(--border);
            transition: background 0.1s;
        }

        .complaint-item:last-child { border-bottom: none; }
        .complaint-item:hover { background: var(--bg-secondary); }

        .complaint-avatar {
            width: 32px; height: 32px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 600;
            flex-shrink: 0; margin-top: 1px;
        }

        .complaint-body { flex: 1; min-width: 0; }

        .complaint-title {
            font-size: 13px; font-weight: 500;
            color: var(--text-primary);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            margin-bottom: 2px;
        }

        .complaint-meta {
            font-size: 11px; color: var(--text-secondary);
            margin-bottom: 4px;
        }

        .complaint-excerpt {
            font-size: 12px; color: var(--text-secondary);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        /* ── BADGE ── */
        .badge {
            font-size: 10px; font-weight: 600;
            padding: 3px 9px; border-radius: 20px;
            flex-shrink: 0; margin-top: 2px;
            white-space: nowrap;
        }

        .badge-pending     { background: #fef3c7; color: #d97706; }
        .badge-ditanggapi  { background: #dbeafe; color: #2563eb; }
        .badge-selesai     { background: #d1fae5; color: #065f46; }

        /* ── RIGHT COL ── */
        .right-col { display: flex; flex-direction: column; gap: 14px; }

        /* ── ACTION LIST ── */
        .action-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 20px;
            text-decoration: none;
            transition: background 0.1s;
        }

        .action-item:hover { background: var(--bg-secondary); }

        .action-dot {
            width: 8px; height: 8px;
            border-radius: 50%; flex-shrink: 0;
        }

        .dot-teal  { background: var(--teal); }
        .dot-amber { background: #d97706; }
        .dot-blue  { background: #2563eb; }

        .action-label { font-size: 13px; color: var(--text-primary); flex: 1; }
        .action-count { font-size: 12px; font-weight: 600; color: var(--text-secondary); }

        /* ── PROGRESS ── */
        .progress-wrap { padding: 16px 20px; display: flex; flex-direction: column; gap: 12px; }

        .progress-row {}
        .progress-labels {
            display: flex; justify-content: space-between;
            font-size: 11px; color: var(--text-secondary);
            margin-bottom: 5px;
        }

        .progress-labels span:last-child { font-weight: 500; color: var(--text-primary); }

        .progress-track {
            height: 5px;
            background: var(--bg-tertiary);
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-fill { height: 100%; border-radius: 10px; }
        .fill-green  { background: #059669; }
        .fill-blue   { background: #2563eb; }
        .fill-amber  { background: #d97706; }

        /* ── SYS INFO ── */
        .sys-list {
            padding: 14px 20px;
            display: flex; flex-direction: column; gap: 10px;
        }

        .sys-row {
            display: flex; justify-content: space-between; align-items: center;
        }

        .sys-key { font-size: 12px; color: var(--text-secondary); }
        .sys-val { font-size: 12px; font-weight: 500; color: var(--text-primary); }
        .sys-val.role { color: var(--teal); }

        /* ── AVATAR COLORS ── */
        .av-teal  { background: var(--teal-mid); color: var(--teal); }
        .av-blue  { background: #dbeafe; color: #2563eb; }
        .av-pink  { background: #fce7f3; color: #db2777; }
        .av-amber { background: #fef3c7; color: #d97706; }
        .av-green { background: #d1fae5; color: #059669; }

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .content-grid { grid-template-columns: 1fr; }
            .right-col { display: grid; grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                flex-direction: row;
                flex-wrap: wrap;
                align-items: center;
                padding: 12px 16px;
            }
            .main { margin-left: 0; padding: 16px; }
            .sidebar-brand { padding: 0; border: none; margin: 0; margin-right: auto; }
            .nav-label, .nav-divider { display: none; }
            .nav-item { padding: 8px 12px; border-left: none; font-size: 12px; }
            .nav-item.active { border-radius: var(--radius-md); border-left: none; }
            .sidebar-bottom { margin-top: 0; padding: 0; border: none; }
            body { flex-direction: column; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .right-col { display: flex; flex-direction: column; }
        }
    </style>
</head>
<body>
    <!-- ── SIDEBAR ── -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-mark">
                <svg viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
            </div>
            <div class="brand-name">Pengaduan<br>Siswa</div>
            <div class="brand-sub">Sistem Manajemen</div>
        </div>

        <span class="nav-label">Menu</span>

        <a href="{{ route('admin.dashboard') }}" class="nav-item active">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="3" y="14" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/>
            </svg>
            Dashboard
        </a>

        <a href="{{ route('admin.pengaduan.index') }}" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
            </svg>
            Kelola Pengaduan
            @if($pendingPengaduan > 0)
                <span class="nav-badge">{{ $pendingPengaduan }}</span>
            @endif
        </a>

        <a href="{{ route('admin.users.index') }}" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
            </svg>
            Kelola Siswa
        </a>

        <div class="sidebar-bottom">
            <div class="user-chip">
                <div class="user-avatar">
                    {{ strtoupper(substr($user->nama, 0, 2)) }}
                </div>
                <div class="user-info">
                    <div class="user-name">{{ $user->nama }}</div>
                    <div class="user-role">{{ ucfirst($user->role) }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn" title="Keluar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- ── MAIN CONTENT ── -->
    <main class="main">

        <!-- Topbar -->
        <div class="topbar">
            <div>
                <div class="page-title">Dashboard</div>
                <div class="page-sub">Selamat datang kembali, {{ $user->nama }}</div>
            </div>
            <div class="date-chip">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                {{ now()->translatedFormat('d F Y') }}
            </div>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat">
                <div class="stat-top">
                    <div class="stat-icon teal">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                    </div>
                </div>
                <div class="stat-num">{{ $totalPengaduan }}</div>
                <div class="stat-label">Total Pengaduan</div>
            </div>

            <div class="stat">
                <div class="stat-top">
                    <div class="stat-icon amber">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                </div>
                <div class="stat-num amber">{{ $pendingPengaduan }}</div>
                <div class="stat-label">Menunggu</div>
            </div>

            <div class="stat">
                <div class="stat-top">
                    <div class="stat-icon blue">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="9 11 12 14 22 4"/>
                            <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
                        </svg>
                    </div>
                </div>
                <div class="stat-num blue">{{ $ditanggapiPengaduan }}</div>
                <div class="stat-label">Ditanggapi</div>
            </div>

            <div class="stat">
                <div class="stat-top">
                    <div class="stat-icon green">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                    </div>
                </div>
                <div class="stat-num green">{{ $selesaiPengaduan }}</div>
                <div class="stat-label">Selesai</div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">

            <!-- Pengaduan Terbaru -->
            <div class="card">
                <div class="card-head">
                    <div class="card-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        Pengaduan Terbaru
                    </div>
                    <a href="{{ route('admin.pengaduan.index') }}" class="card-action">
                        Lihat semua →
                    </a>
                </div>

                @if($recentPengaduan->count() > 0)
                    @php
                        $avatarColors = ['av-teal','av-blue','av-pink','av-amber','av-green'];
                    @endphp
                    @foreach($recentPengaduan as $i => $pengaduan)
                        <div class="complaint-item">
                            <div class="complaint-avatar {{ $avatarColors[$i % count($avatarColors)] }}">
                                {{ strtoupper(substr($pengaduan->user->nama, 0, 2)) }}
                            </div>
                            <div class="complaint-body">
                                <div class="complaint-title">{{ $pengaduan->judul }}</div>
                                <div class="complaint-meta">
                                    {{ $pengaduan->user->nama }}
                                    &nbsp;·&nbsp;
                                    {{ $pengaduan->created_at->diffForHumans() }}
                                </div>
                                <div class="complaint-excerpt">{{ Str::limit($pengaduan->isi_laporan, 90) }}</div>
                            </div>
                            <span class="badge badge-{{ $pengaduan->status }}">
                                {{ ucfirst($pengaduan->status) }}
                            </span>
                        </div>
                    @endforeach
                @else
                    <div style="text-align:center; padding: 48px 20px; color: var(--text-secondary); font-size: 13px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                             style="width:36px;height:36px;margin:0 auto 10px;display:block;color:var(--text-tertiary)">
                            <rect x="2" y="3" width="20" height="14" rx="2"/>
                            <path d="M8 21h8M12 17v4"/>
                        </svg>
                        Belum ada pengaduan
                    </div>
                @endif
            </div>

            <!-- Right Column -->
            <div class="right-col">

                <!-- Aksi Cepat -->
                <div class="card">
                    <div class="card-head">
                        <div class="card-title">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                            </svg>
                            Aksi Cepat
                        </div>
                    </div>
                    <a href="{{ route('admin.pengaduan.index') }}?status=pending" class="action-item">
                        <div class="action-dot dot-amber"></div>
                        <span class="action-label">Pengaduan Pending</span>
                        <span class="action-count">{{ $pendingPengaduan }}</span>
                    </a>
                    <a href="{{ route('admin.pengaduan.index') }}?status=ditanggapi" class="action-item">
                        <div class="action-dot dot-blue"></div>
                        <span class="action-label">Pengaduan Ditanggapi</span>
                        <span class="action-count">{{ $ditanggapiPengaduan }}</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="action-item">
                        <div class="action-dot dot-teal"></div>
                        <span class="action-label">Total Siswa</span>
                        <span class="action-count">{{ $totalSiswa }}</span>
                    </a>
                </div>

                <!-- Distribusi Status -->
                <div class="card">
                    <div class="card-head">
                        <div class="card-title">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="20" x2="18" y2="10"/>
                                <line x1="12" y1="20" x2="12" y2="4"/>
                                <line x1="6" y1="20" x2="6" y2="14"/>
                            </svg>
                            Distribusi Status
                        </div>
                    </div>
                    <div class="progress-wrap">
                        @php
                            $total = max($totalPengaduan, 1);
                            $pctSelesai    = round(($selesaiPengaduan / $total) * 100);
                            $pctDitanggapi = round(($ditanggapiPengaduan / $total) * 100);
                            $pctPending    = round(($pendingPengaduan / $total) * 100);
                        @endphp

                        <div class="progress-row">
                            <div class="progress-labels">
                                <span>Selesai</span>
                                <span>{{ $selesaiPengaduan }} pengaduan</span>
                            </div>
                            <div class="progress-track">
                                <div class="progress-fill fill-green" style="width: {{ $pctSelesai }}%"></div>
                            </div>
                        </div>

                        <div class="progress-row">
                            <div class="progress-labels">
                                <span>Ditanggapi</span>
                                <span>{{ $ditanggapiPengaduan }} pengaduan</span>
                            </div>
                            <div class="progress-track">
                                <div class="progress-fill fill-blue" style="width: {{ $pctDitanggapi }}%"></div>
                            </div>
                        </div>

                        <div class="progress-row">
                            <div class="progress-labels">
                                <span>Pending</span>
                                <span>{{ $pendingPengaduan }} pengaduan</span>
                            </div>
                            <div class="progress-track">
                                <div class="progress-fill fill-amber" style="width: {{ $pctPending }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Sistem -->
                <div class="card">
                    <div class="card-head">
                        <div class="card-title">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            Info Sistem
                        </div>
                    </div>
                    <div class="sys-list">
                        <div class="sys-row">
                            <span class="sys-key">Tanggal</span>
                            <span class="sys-val">{{ now()->format('d M Y') }}</span>
                        </div>
                        <div class="sys-row">
                            <span class="sys-key">Waktu</span>
                            <span class="sys-val" id="clock">{{ now()->format('H:i') }}</span>
                        </div>
                        <div class="sys-row">
                            <span class="sys-key">Role</span>
                            <span class="sys-val role">{{ ucfirst($user->role) }}</span>
                        </div>
                        <div class="sys-row">
                            <span class="sys-key">Versi App</span>
                            <span class="sys-val">v1.0.0</span>
                        </div>
                    </div>
                </div>

            </div><!-- end right-col -->
        </div><!-- end content-grid -->
    </main>

    <script>
        // Live clock
        function updateClock() {
            const now = new Date();
            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            const el = document.getElementById('clock');
            if (el) el.textContent = h + ':' + m;
        }
        updateClock();
        setInterval(updateClock, 1000);
    </script>
</body>
</html>