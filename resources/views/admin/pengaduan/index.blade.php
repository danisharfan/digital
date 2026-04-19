<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Pengaduan - Admin</title>
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
            background: linear-gradient(135deg, #0d7377 0%, #14919b 25%, #00d4ff 50%, #14919b 75%, #0d7377 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            min-height: 100vh;
            padding: 20px;
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
        }

        .btn-primary {
            background: linear-gradient(135deg, #00a8cc 0%, #00d4ff 100%);
            color: white;
            border: none;
            border-radius: 14px;
            padding: 12px 24px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 168, 204, 0.3);
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-pending { background: #fef3c7; color: #d97706; }
        .status-ditanggapi { background: #dbeafe; color: #2563eb; }
        .status-selesai { background: #d1fae5; color: #065f46; }

        .filter-btn {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s;
        }

        .filter-btn.active {
            background: linear-gradient(135deg, #00a8cc 0%, #00d4ff 100%);
            color: white;
        }

        .filter-btn:not(.active) {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .filter-btn:not(.active):hover {
            background: #e5e7eb;
        }
    </style>
</head>
<body>
    <div class="max-w-7xl mx-auto">
        <div class="dashboard-card p-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Kelola Pengaduan</h1>
                    <p class="text-gray-600">Pantau dan kelola semua pengaduan siswa</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                    <a href="{{ route('admin.dashboard') }}" class="btn-primary text-center">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            <!-- Filters -->
            <div class="mb-6">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.pengaduan.index') }}" class="filter-btn {{ !request('status') ? 'active' : '' }}">
                        <i class="fas fa-list mr-1"></i>Semua ({{ $pengaduan->total() }})
                    </a>
                    <a href="{{ route('admin.pengaduan.index', ['status' => 'pending']) }}" class="filter-btn {{ request('status') === 'pending' ? 'active' : '' }}">
                        <i class="fas fa-clock mr-1"></i>Pending ({{ \App\Models\Pengaduan::where('status', 'pending')->count() }})
                    </a>
                    <a href="{{ route('admin.pengaduan.index', ['status' => 'ditanggapi']) }}" class="filter-btn {{ request('status') === 'ditanggapi' ? 'active' : '' }}">
                        <i class="fas fa-reply mr-1"></i>Ditanggapi ({{ \App\Models\Pengaduan::where('status', 'ditanggapi')->count() }})
                    </a>
                    <a href="{{ route('admin.pengaduan.index', ['status' => 'selesai']) }}" class="filter-btn {{ request('status') === 'selesai' ? 'active' : '' }}">
                        <i class="fas fa-check-circle mr-1"></i>Selesai ({{ \App\Models\Pengaduan::where('status', 'selesai')->count() }})
                    </a>
                </div>
            </div>

            @if($pengaduan->count() > 0)
                <div class="space-y-4">
                    @foreach($pengaduan as $item)
                        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition duration-200">
                            <div class="flex flex-col lg:flex-row gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 mb-3">
                                        <h3 class="text-lg md:text-xl font-semibold text-gray-800 truncate">{{ $item->judul }}</h3>
                                        <span class="status-badge status-{{ $item->status }} self-start flex-shrink-0">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </div>
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($item->isi_laporan, 150) }}</p>
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 text-sm text-gray-500 mb-3">
                                        <span class="flex items-center">
                                            <i class="fas fa-user mr-1"></i>{{ $item->user->nama }} ({{ $item->user->username }})
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-calendar mr-1"></i>{{ $item->tanggal_lapor->format('d M Y H:i') }}
                                        </span>
                                        @if($item->feedback_at)
                                            <span class="flex items-center text-green-600">
                                                <i class="fas fa-reply mr-1"></i>Ditanggapi {{ $item->feedback_at->diffForHumans() }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('admin.pengaduan.show', $item) }}" class="inline-flex items-center px-3 py-1 text-sm font-medium text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-md transition">
                                            <i class="fas fa-eye mr-1"></i>Lihat & Kelola
                                        </a>
                                        @if($item->foto)
                                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-gray-600 bg-gray-100 rounded-md">
                                                <i class="fas fa-image mr-1"></i>Foto
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @if($item->foto)
                                    <div class="flex-shrink-0">
                                        <img src="{{ Storage::url($item->foto) }}" alt="Foto pengaduan" class="w-20 h-20 md:w-24 md:h-24 object-cover rounded-lg border border-gray-200">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $pengaduan->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-inbox text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">
                        @if(request('status'))
                            Tidak ada pengaduan dengan status {{ ucfirst(request('status')) }}
                        @else
                            Belum ada pengaduan
                        @endif
                    </h3>
                    <p class="text-gray-500 mb-6 max-w-md mx-auto">
                        @if(request('status'))
                            Saat ini tidak ada pengaduan dengan status yang dipilih.
                        @else
                            Belum ada siswa yang membuat pengaduan.
                        @endif
                    </p>
                    @if(request('status'))
                        <a href="{{ route('admin.pengaduan.index') }}" class="btn-primary inline-block">
                            <i class="fas fa-list mr-2"></i>Lihat Semua Pengaduan
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</body>
</html>