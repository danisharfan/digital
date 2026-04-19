<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pengaduan - Admin</title>
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

        .btn-primary {
            background: linear-gradient(135deg, #00a8cc 0%, #00d4ff 100%);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 168, 204, 0.3);
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
            border: 2px solid #d1d5db;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
            transform: translateY(-2px);
        }

        .feedback-card {
            background: linear-gradient(135deg, #f0fffe 0%, #e0f7ff 100%);
            border: 1px solid rgba(0, 168, 204, 0.2);
            border-radius: 16px;
            padding: 20px;
        }

        .form-input, .form-textarea, .form-select {
            width: 100%;
            padding: 12px 16px;
            font-size: 1rem;
            border: 2px solid #d1eff5;
            border-radius: 12px;
            background: linear-gradient(135deg, #f0fffe 0%, #e0f7ff 100%);
            color: #0d7377;
            transition: all 0.3s;
            font-weight: 500;
        }

        .form-input:focus, .form-textarea:focus, .form-select:focus {
            outline: none;
            border-color: #00a8cc;
            background: linear-gradient(135deg, #ffffff 0%, #f0fffe 100%);
            box-shadow: 0 0 0 3px rgba(0, 168, 204, 0.15);
            transform: translateY(-1px);
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }
    </style>
</head>
<body>
    <div class="max-w-6xl mx-auto">
        <div class="detail-card p-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Detail Pengaduan</h1>
                    <p class="text-gray-600">Kelola pengaduan siswa</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('admin.pengaduan.index') }}" class="btn-action btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Pengaduan Detail -->
                <div class="lg:col-span-2">
                    <div class="bg-white border border-gray-200 rounded-xl p-6 mb-6">
                        <div class="flex justify-between items-start gap-4 mb-4">
                            <h2 class="text-2xl font-semibold text-gray-800 flex-1">{{ $pengaduan->judul }}</h2>
                            <span class="status-badge status-{{ $pengaduan->status }} flex-shrink-0">
                                {{ ucfirst($pengaduan->status) }}
                            </span>
                        </div>

                        <div class="space-y-4 mb-6">
                            <div class="grid md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="font-medium text-gray-600">Siswa:</span>
                                    <p class="text-gray-800">{{ $pengaduan->user->nama }} ({{ $pengaduan->user->username }})</p>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Tanggal Lapor:</span>
                                    <p class="text-gray-800">{{ $pengaduan->tanggal_lapor->format('d M Y H:i') }}</p>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Dibuat:</span>
                                    <p class="text-gray-800">{{ $pengaduan->created_at->format('d M Y H:i') }}</p>
                                </div>
                                @if($pengaduan->updated_at != $pengaduan->created_at)
                                    <div>
                                        <span class="font-medium text-gray-600">Terakhir Diubah:</span>
                                        <p class="text-gray-800">{{ $pengaduan->updated_at->format('d M Y H:i') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <h3 class="font-semibold text-gray-800 mb-3">Isi Laporan:</h3>
                            <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $pengaduan->isi_laporan }}</p>
                        </div>

                        @if($pengaduan->foto)
                            <div class="mb-6">
                                <h3 class="font-semibold text-gray-800 mb-3">Foto Pendukung:</h3>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <img src="{{ Storage::url($pengaduan->foto) }}" alt="Foto pengaduan" class="max-w-full h-auto rounded-lg shadow-sm">
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Feedback Section -->
                    @if($pengaduan->feedback)
                        <div class="feedback-card">
                            <h3 class="font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-reply mr-2 text-blue-600"></i>
                                Tanggapan Admin
                            </h3>
                            <div class="bg-white rounded-lg p-4 border border-blue-200">
                                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $pengaduan->feedback }}</p>
                                <div class="mt-3 text-sm text-gray-500">
                                    <i class="fas fa-calendar mr-1"></i>Ditanggapi pada {{ $pengaduan->feedback_at->format('d M Y H:i') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Action Panel -->
                <div>
                    <div class="bg-white border border-gray-200 rounded-xl p-6 sticky top-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Kelola Pengaduan</h3>

                        <form action="{{ route('admin.pengaduan.update-status', $pengaduan) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-tasks mr-1"></i>Status Pengaduan
                                </label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="pending" {{ $pengaduan->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="ditanggapi" {{ $pengaduan->status === 'ditanggapi' ? 'selected' : '' }}>Ditanggapi</option>
                                    <option value="selesai" {{ $pengaduan->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>

                            <div class="mb-6">
                                <label for="feedback" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-comment mr-1"></i>Tanggapan Admin
                                </label>
                                <textarea
                                    name="feedback"
                                    id="feedback"
                                    rows="6"
                                    class="form-textarea"
                                    placeholder="Berikan tanggapan atau feedback untuk siswa..."
                                >{{ $pengaduan->feedback }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Opsional: Berikan penjelasan atau solusi untuk pengaduan ini</p>
                            </div>

                            <button type="submit" class="btn-primary w-full">
                                <i class="fas fa-save mr-2"></i>Simpan Perubahan
                            </button>
                        </form>

                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="text-xs text-gray-500 space-y-1">
                                <div><i class="fas fa-info-circle mr-1"></i>Status akan otomatis tersimpan</div>
                                <div><i class="fas fa-clock mr-1"></i>Perubahan terakhir: {{ $pengaduan->updated_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>