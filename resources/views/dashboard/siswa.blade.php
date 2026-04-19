<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard Siswa - Pengaduan Siswa</title>
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
                max-width: 600px;
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

            .feature-icon {
                width: 60px;
                height: 60px;
                background: linear-gradient(135deg, #00a8cc 0%, #00d4ff 100%);
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.8rem;
                margin-bottom: 16px;
                box-shadow: 0 4px 12px rgba(0, 168, 204, 0.3);
            }

            .stat-card {
                background: white;
                border: 1px solid #e5e7eb;
                border-radius: 12px;
                padding: 16px;
                text-align: center;
                transition: all 0.3s;
            }

            .stat-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }
        </style>
    </head>
    <body class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="dashboard-card" style="padding: 32px;">
            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-3 bg-gradient-to-r from-blue-100 to-cyan-100 border border-blue-200 px-4 py-2 rounded-full mb-4">
                    <i class="fas fa-user-graduate text-blue-600"></i>
                    <span class="text-sm font-semibold text-blue-700 uppercase tracking-wide">Dashboard Siswa</span>
                </div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-700 to-cyan-600 bg-clip-text text-transparent mb-2">
                    Selamat Datang, {{ $user->nama }}!
                </h1>
                <p class="text-gray-600">Kelola pengaduan Anda dengan mudah dan efisien</p>
            </div>

            <div class="grid gap-6 mb-8">
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Buat Pengaduan Baru</h3>
                        <p class="text-gray-600 text-sm mb-4">Laporkan masalah atau keluhan Anda dengan detail</p>
                        <a href="{{ route('pengaduan.create') }}" class="btn-primary w-full block text-center">
                            <i class="fas fa-plus mr-2"></i>Buat Pengaduan
                        </a>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-list-ul"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Lihat Pengaduan Saya</h3>
                        <p class="text-gray-600 text-sm mb-4">Pantau status dan riwayat pengaduan Anda</p>
                        <a href="{{ route('pengaduan.index') }}" class="btn-primary w-full block text-center">
                            <i class="fas fa-eye mr-2"></i>Lihat Pengaduan
                        </a>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Statistik Pengaduan</h3>
                    <p class="text-gray-600 text-sm mb-4">Lihat ringkasan pengaduan Anda</p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 text-center">
                            <div class="flex items-center justify-center mb-1">
                                <i class="fas fa-clock text-yellow-600 mr-2"></i>
                                <span class="text-sm font-medium text-yellow-800">Pending</span>
                            </div>
                    <div class="text-3xl font-bold text-yellow-700">{{ \App\Models\Pengaduan::where('id_user', $user->id)->where('status', 'pending')->count() }}</div>
                        </div>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-center">
                            <div class="flex items-center justify-center mb-1">
                                <i class="fas fa-check-circle text-blue-600 mr-2"></i>
                                <span class="text-sm font-medium text-blue-800">Ditanggapi</span>
                            </div>
                            <div class="text-2xl font-bold text-blue-700">{{ \App\Models\Pengaduan::where('id_user', $user->id)->where('status', 'ditanggapi')->count() }}</div>
                        </div>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-3 text-center">
                            <div class="flex items-center justify-center mb-1">
                                <i class="fas fa-check-double text-green-600 mr-2"></i>
                                <span class="text-sm font-medium text-green-800">Selesai</span>
                            </div>
                            <div class="text-2xl font-bold text-green-700">{{ \App\Models\Pengaduan::where('id_user', $user->id)->where('status', 'selesai')->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="btn-secondary">
                        <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                    </button>
                </form>
            </div>
        </div>
    </body>
</html>
