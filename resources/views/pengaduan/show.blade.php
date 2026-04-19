<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pengaduan - Pengaduan Siswa</title>
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

        .detail-card {
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid rgba(13, 115, 119, 0.2);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25),
                        inset 0 1px 0 0 rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            overflow: hidden;
        }

        .status-badge {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .status-pending { background: #fef3c7; color: #d97706; }
        .status-ditanggapi { background: #dbeafe; color: #2563eb; }
        .status-selesai { background: #d1fae5; color: #065f46; }

        .btn-action {
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-edit { background: #f59e0b; color: white; }
        .btn-edit:hover { background: #d97706; transform: translateY(-2px); }

        .btn-delete { background: #ef4444; color: white; }
        .btn-delete:hover { background: #dc2626; transform: translateY(-2px); }

        .btn-back { background: #6b7280; color: white; }
        .btn-back:hover { background: #4b5563; transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="max-w-4xl mx-auto">
        <div class="detail-card p-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Detail Pengaduan</h1>
                    <p class="text-gray-600">Informasi lengkap pengaduan Anda</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('pengaduan.index') }}" class="btn-action btn-back">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    @if($pengaduan->status === 'pending')
                        <a href="{{ route('pengaduan.edit', $pengaduan) }}" class="btn-action btn-edit">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>
                        <form action="{{ route('pengaduan.destroy', $pengaduan) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-delete">
                                <i class="fas fa-trash mr-2"></i>Hapus
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="md:col-span-2">
                    <div class="mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ $pengaduan->judul }}</h2>
                        <div class="bg-gray-50 rounded-lg p-6">
                            <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $pengaduan->isi_laporan }}</p>
                        </div>
                    </div>

                    @if($pengaduan->foto)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-3">Foto Pendukung</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <img src="{{ Storage::url($pengaduan->foto) }}" alt="Foto pengaduan" class="max-w-full h-auto rounded-lg shadow-sm">
                            </div>
                        </div>
                    @endif
                </div>

                <div>
                    <div class="bg-gray-50 rounded-lg p-6 sticky top-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pengaduan</h3>
                        <div class="space-y-4">
                            <div>
                                <span class="text-sm font-medium text-gray-600 block mb-1">Status:</span>
                                <span class="status-badge status-{{ $pengaduan->status }} inline-block">
                                    {{ ucfirst($pengaduan->status) }}
                                </span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600 block mb-1">Tanggal Lapor:</span>
                                <p class="text-gray-800 font-medium">{{ $pengaduan->tanggal_lapor->format('d M Y H:i') }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600 block mb-1">Dibuat:</span>
                                <p class="text-gray-800">{{ $pengaduan->created_at->format('d M Y H:i') }}</p>
                            </div>
                            @if($pengaduan->updated_at != $pengaduan->created_at)
                                <div>
                                    <span class="text-sm font-medium text-gray-600 block mb-1">Terakhir Diubah:</span>
                                    <p class="text-gray-800">{{ $pengaduan->updated_at->format('d M Y H:i') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>