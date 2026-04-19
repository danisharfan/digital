<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buat Pengaduan Baru - Pengaduan Siswa</title>
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

        .form-card {
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid rgba(13, 115, 119, 0.2);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25),
                        inset 0 1px 0 0 rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            overflow: hidden;
        }

        .form-input, .form-textarea {
            width: 100%;
            padding: 14px 18px;
            font-size: 1rem;
            border: 2px solid #d1eff5;
            border-radius: 14px;
            background: linear-gradient(135deg, #f0fffe 0%, #e0f7ff 100%);
            color: #0d7377;
            transition: all 0.3s;
            font-weight: 500;
        }

        .form-input:focus, .form-textarea:focus {
            outline: none;
            border-color: #00a8cc;
            background: linear-gradient(135deg, #ffffff 0%, #f0fffe 100%);
            box-shadow: 0 0 0 4px rgba(0, 168, 204, 0.15);
            transform: translateY(-2px);
        }

        .form-label {
            display: block;
            font-size: 0.95rem;
            font-weight: 600;
            color: #0d7377;
            margin-bottom: 10px;
        }

        .btn-submit {
            width: 100%;
            padding: 14px 24px;
            font-size: 1.05rem;
            font-weight: 700;
            color: white;
            background: linear-gradient(135deg, #00a8cc 0%, #00d4ff 100%);
            border: none;
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 10px 25px rgba(0, 168, 204, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(0, 168, 204, 0.4);
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
    </style>
</head>
<body>
    <div class="max-w-2xl mx-auto">
        <div class="form-card p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Buat Pengaduan Baru</h1>
                <p class="text-gray-600">Isi formulir di bawah ini untuk membuat pengaduan</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-6">
                    <label for="judul" class="form-label">
                        <i class="fas fa-heading mr-2"></i>Judul Pengaduan
                    </label>
                    <input
                        type="text"
                        id="judul"
                        name="judul"
                        value="{{ old('judul') }}"
                        placeholder="Masukkan judul pengaduan"
                        required
                        class="form-input"
                    />
                </div>

                <div class="mb-6">
                    <label for="isi_laporan" class="form-label">
                        <i class="fas fa-file-alt mr-2"></i>Isi Laporan
                    </label>
                    <textarea
                        id="isi_laporan"
                        name="isi_laporan"
                        rows="6"
                        placeholder="Jelaskan detail pengaduan Anda..."
                        required
                        class="form-textarea"
                    >{{ old('isi_laporan') }}</textarea>
                </div>

                <div class="mb-8">
                    <label for="foto" class="form-label">
                        <i class="fas fa-camera mr-2"></i>Foto (Opsional)
                    </label>
                    <input
                        type="file"
                        id="foto"
                        name="foto"
                        accept="image/*"
                        class="form-input"
                    />
                    <p class="text-sm text-gray-500 mt-2">Format: JPG, PNG, GIF. Maksimal 2MB.</p>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="btn-submit flex-1">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim Pengaduan
                    </button>
                    <a href="{{ route('pengaduan.index') }}" class="btn-secondary px-6 py-3 rounded-lg font-semibold">
                        <i class="fas fa-arrow-left mr-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
    <script>
        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const previewImg = document.getElementById('preview-img');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.classList.remove('hidden');
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.classList.add('hidden');
            }
        }
    </script>
</body>
</html>