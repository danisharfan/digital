<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Pengaduan - Pengaduan Siswa</title>
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

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <div class="max-w-6xl mx-auto">
        <div class="dashboard-card p-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Daftar Pengaduan</h1>
                    <p class="text-gray-600">Kelola pengaduan Anda dengan mudah</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                    <a href="{{ route('siswa.dashboard') }}" class="btn-primary text-center">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
                    </a>
                    <a href="{{ route('pengaduan.create') }}" class="btn-primary text-center">
                        <i class="fas fa-plus mr-2"></i>Buat Pengaduan Baru
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            @if($pengaduan->count() > 0)
                <div class="grid gap-4 md:gap-6">
                    @foreach($pengaduan as $item)
                        <div class="bg-white border border-gray-200 rounded-xl p-4 md:p-6 shadow-sm hover:shadow-md transition duration-200">
                            <div class="flex flex-col lg:flex-row gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 mb-3">
                                        <h3 class="text-lg md:text-xl font-semibold text-gray-800 truncate">{{ $item->judul }}</h3>
                                        <span class="status-badge status-{{ $item->status }} self-start flex-shrink-0">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </div>
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($item->isi_laporan, 150) }}</p>
                                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-3">
                                        <span class="flex items-center">
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ $item->tanggal_lapor->format('d M Y H:i') }}
                                        </span>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('pengaduan.show', $item) }}" class="inline-flex items-center px-3 py-1 text-sm font-medium text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-md transition">
                                            <i class="fas fa-eye mr-1"></i>Lihat Detail
                                        </a>
                                        @if($item->status === 'pending')
                                            <a href="{{ route('pengaduan.edit', $item) }}" class="inline-flex items-center px-3 py-1 text-sm font-medium text-yellow-600 hover:text-yellow-800 hover:bg-yellow-50 rounded-md transition">
                                                <i class="fas fa-edit mr-1"></i>Edit
                                            </a>
                                            <form action="{{ route('pengaduan.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1 text-sm font-medium text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md transition">
                                                    <i class="fas fa-trash mr-1"></i>Hapus
                                                </button>
                                            </form>
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
            @else
                <div class="text-center py-16">
                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-inbox text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum ada pengaduan</h3>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto">Anda belum membuat pengaduan apapun. Mulai buat pengaduan pertama Anda untuk melaporkan masalah atau keluhan.</p>
                    <a href="{{ route('pengaduan.create') }}" class="btn-primary inline-block">
                        <i class="fas fa-plus mr-2"></i>Buat Pengaduan Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>