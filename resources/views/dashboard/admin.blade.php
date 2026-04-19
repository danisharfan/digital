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
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            * {
                font-family: 'Poppins', sans-serif;
            }

            body {
                display: flex;
                align-items: center;
                justify-content: center;
                background: linear-gradient(135deg, #0d7377 0%, #14919b 25%, #00d4ff 50%, #14919b 75%, #0d7377 100%);
                background-size: 400% 400%;
                animation: gradientShift 15s ease infinite;
                min-height: 100vh;
            }

            @keyframes gradientShift {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            .dashboard-card {
                background: rgba(255, 255, 255, 0.96);
                border: 1px solid rgba(13, 115, 119, 0.2);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25),
                            inset 0 1px 0 0 rgba(255, 255, 255, 0.6);
                backdrop-filter: blur(20px);
                border-radius: 24px;
                overflow: hidden;
                max-width: 1200px;
                width: 100%;
            }

            .btn-primary {
                background: linear-gradient(135deg, #00a8cc 0%, #00d4ff 100%);
                color: white;
                border: none;
                border-radius: 14px;
                padding: 14px 24px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s;
                text-decoration: none;
                display: inline-block;
                text-align: center;
            }

            .btn-primary:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 25px rgba(0, 168, 204, 0.3);
            }

            .btn-secondary {
                background: #f3f4f6;
                color: #374151;
                border: 2px solid #d1d5db;
                border-radius: 14px;
                padding: 14px 24px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s;
                text-decoration: none;
                display: inline-block;
                text-align: center;
            }

            .btn-secondary:hover {
                background: #e5e7eb;
                transform: translateY(-2px);
            }

            .stat-card {
                background: white;
                border: 1px solid #e5e7eb;
                border-radius: 16px;
                padding: 20px;
                text-align: center;
                transition: all 0.3s;
                height: 100%;
            }

            .stat-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }

            .stat-icon {
                width: 50px;
                height: 50px;
                background: linear-gradient(135deg, #00a8cc 0%, #00d4ff 100%);
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.5rem;
                margin: 0 auto 12px;
                box-shadow: 0 4px 12px rgba(0, 168, 204, 0.3);
            }

            .feature-card {
                background: linear-gradient(135deg, #f0fffe 0%, #e0f7ff 100%);
                border: 1px solid rgba(0, 168, 204, 0.2);
                border-radius: 16px;
                padding: 24px;
                transition: all 0.3s;
                height: 100%;
            }

            .feature-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 10px 25px rgba(0, 168, 204, 0.2);
            }

            .recent-item {
                background: white;
                border: 1px solid #e5e7eb;
                border-radius: 12px;
                padding: 16px;
                transition: all 0.3s;
            }

            .recent-item:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            .status-badge {
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 0.75rem;
                font-weight: 600;
            }

            .status-pending { background: #fef3c7; color: #d97706; }
            .status-ditanggapi { background: #dbeafe; color: #2563eb; }
            .status-selesai { background: #d1fae5; color: #065f46; }
        </style>
    </head>
    <body class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="dashboard-card" style="padding: 32px;">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-8">
                <div>
                    <div class="inline-flex items-center gap-3 bg-gradient-to-r from-red-100 to-pink-100 border border-red-200 px-4 py-2 rounded-full mb-4">
                        <i class="fas fa-crown text-red-600"></i>
                        <span class="text-sm font-semibold text-red-700 uppercase tracking-wide">Dashboard Admin</span>
                    </div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-700 to-cyan-600 bg-clip-text text-transparent mb-2">
                        Selamat Datang, {{ $user->nama }}!
                    </h1>
                    <p class="text-gray-600">Kelola semua pengaduan siswa dengan efisien</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('admin.pengaduan.index') }}" class="btn-primary">
                        <i class="fas fa-list mr-2"></i>Kelola Pengaduan
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn-primary">
                        <i class="fas fa-users mr-2"></i>Kelola Siswa
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="btn-secondary">
                            <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Statistics Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="text-3xl font-bold text-gray-800 mb-1">{{ $totalPengaduan }}</div>
                    <div class="text-sm text-gray-600 font-medium">Total Pengaduan</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="text-3xl font-bold text-yellow-600 mb-1">{{ $pendingPengaduan }}</div>
                    <div class="text-sm text-gray-600 font-medium">Menunggu</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-reply"></i>
                    </div>
                    <div class="text-3xl font-bold text-blue-600 mb-1">{{ $ditanggapiPengaduan }}</div>
                    <div class="text-sm text-gray-600 font-medium">Ditanggapi</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="text-3xl font-bold text-green-600 mb-1">{{ $selesaiPengaduan }}</div>
                    <div class="text-sm text-gray-600 font-medium">Selesai</div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Recent Pengaduan -->
                <div class="lg:col-span-2">
                    <div class="feature-card">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-clock mr-2 text-blue-600"></i>
                            Pengaduan Terbaru
                        </h3>

                        @if($recentPengaduan->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentPengaduan as $pengaduan)
                                    <div class="recent-item">
                                        <div class="flex justify-between items-start gap-3">
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-semibold text-gray-800 truncate">{{ $pengaduan->judul }}</h4>
                                                <p class="text-sm text-gray-600 mb-2">
                                                    <i class="fas fa-user mr-1"></i>{{ $pengaduan->user->nama }}
                                                    <span class="mx-2">•</span>
                                                    {{ $pengaduan->created_at->diffForHumans() }}
                                                </p>
                                                <p class="text-sm text-gray-700 line-clamp-2">{{ Str::limit($pengaduan->isi_laporan, 100) }}</p>
                                            </div>
                                            <span class="status-badge status-{{ $pengaduan->status }} flex-shrink-0">
                                                {{ ucfirst($pengaduan->status) }}
                                            </span>
                                        </div>
                                        <div class="mt-3 flex gap-2">
                                            <a href="{{ route('admin.pengaduan.show', $pengaduan) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                <i class="fas fa-eye mr-1"></i>Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4 text-center">
                                <a href="{{ route('admin.pengaduan.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                    Lihat Semua Pengaduan <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500">Belum ada pengaduan</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions & Stats -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="feature-card">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-bolt mr-2 text-yellow-600"></i>
                            Aksi Cepat
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.pengaduan.index') }}?status=pending" class="flex items-center justify-between p-3 bg-yellow-50 border border-yellow-200 rounded-lg hover:bg-yellow-100 transition">
                                <div class="flex items-center">
                                    <i class="fas fa-clock text-yellow-600 mr-3"></i>
                                    <span class="font-medium text-yellow-800">Pengaduan Pending</span>
                                </div>
                                <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">{{ $pendingPengaduan }}</span>
                            </a>

                            <a href="{{ route('admin.users.index') }}" class="flex items-center justify-between p-3 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition">
                                <div class="flex items-center">
                                    <i class="fas fa-users text-blue-600 mr-3"></i>
                                    <span class="font-medium text-blue-800">Total Siswa</span>
                                </div>
                                <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold">{{ $totalSiswa }}</span>
                            </a>
                        </div>
                    </div>

                    <!-- System Info -->
                    <div class="feature-card">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-info-circle mr-2 text-green-600"></i>
                            Info Sistem
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal:</span>
                                <span class="font-medium">{{ now()->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Waktu:</span>
                                <span class="font-medium">{{ now()->format('H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Role:</span>
                                <span class="font-medium text-red-600">{{ ucfirst($user->role) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
