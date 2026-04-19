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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        *{
            font-family:'Poppins',sans-serif;
        }

        body{
            background: linear-gradient(135deg,#0d7377 0%,#14919b 30%,#00d4ff 60%,#0d7377 100%);
            background-size:400% 400%;
            animation:bgMove 12s ease infinite;
            min-height:100vh;
            padding:25px;
        }

        @keyframes bgMove{
            0%{background-position:0% 50%;}
            50%{background-position:100% 50%;}
            100%{background-position:0% 50%;}
        }

        .card-form{
            max-width:760px;
            margin:auto;
            background:rgba(255,255,255,.96);
            border-radius:24px;
            padding:35px;
            box-shadow:0 20px 45px rgba(0,0,0,.18);
            border:1px solid rgba(255,255,255,.5);
        }

        .title{
            font-size:30px;
            font-weight:800;
            color:#0f172a;
            margin-bottom:6px;
        }

        .sub{
            color:#64748b;
            font-size:14px;
            margin-bottom:28px;
        }

        .label{
            display:block;
            font-size:14px;
            font-weight:600;
            color:#0d7377;
            margin-bottom:8px;
        }

        .input,
        .textarea,
        .file-input{
            width:100%;
            border:2px solid #dbeafe;
            background:#f8fafc;
            border-radius:14px;
            padding:14px 16px;
            font-size:14px;
            transition:.25s;
            outline:none;
        }

        .textarea{
            resize:none;
            min-height:160px;
        }

        .input:focus,
        .textarea:focus,
        .file-input:focus{
            border-color:#00a8cc;
            background:#fff;
            box-shadow:0 0 0 4px rgba(0,168,204,.12);
        }

        .info{
            font-size:12px;
            color:#64748b;
            margin-top:8px;
        }

        .btn-main{
            background:linear-gradient(135deg,#00a8cc,#00d4ff);
            color:#fff;
            border:none;
            padding:14px 24px;
            border-radius:14px;
            font-weight:700;
            transition:.25s;
            text-decoration:none;
            text-align:center;
            display:inline-block;
        }

        .btn-main:hover{
            transform:translateY(-2px);
            box-shadow:0 12px 25px rgba(0,168,204,.25);
        }

        .btn-light{
            background:#eef2f7;
            color:#334155;
            padding:14px 24px;
            border-radius:14px;
            font-weight:600;
            text-decoration:none;
            display:inline-block;
            text-align:center;
            transition:.25s;
        }

        .btn-light:hover{
            background:#e2e8f0;
        }

        .preview-box{
            margin-top:14px;
            display:none;
        }

        .preview-box img{
            width:140px;
            height:140px;
            object-fit:cover;
            border-radius:16px;
            border:2px solid #e5e7eb;
        }

        .error-box{
            background:#fee2e2;
            color:#b91c1c;
            border:1px solid #fecaca;
            padding:15px;
            border-radius:14px;
            margin-bottom:20px;
        }

        .action{
            display:grid;
            grid-template-columns:1fr auto;
            gap:14px;
            margin-top:30px;
        }

        @media(max-width:640px){
            body{
                padding:14px;
            }

            .card-form{
                padding:22px;
            }

            .title{
                font-size:24px;
            }

            .action{
                grid-template-columns:1fr;
            }

            .btn-main,
            .btn-light{
                width:100%;
            }
        }
    </style>
</head>

<body>

<div class="card-form">

    <div class="mb-6">
        <h1 class="title">
            <i class="fas fa-paper-plane text-cyan-500 mr-2"></i>
            Buat Pengaduan Baru
        </h1>
        <p class="sub">
            Sampaikan keluhan atau laporan Anda dengan jelas agar cepat diproses admin.
        </p>
    </div>

    @if ($errors->any())
        <div class="error-box">
            <ul class="list-disc ml-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Judul -->
        <div class="mb-5">
            <label class="label">
                <i class="fas fa-heading mr-1"></i> Judul Pengaduan
            </label>

            <input
                type="text"
                name="judul"
                value="{{ old('judul') }}"
                class="input"
                placeholder="Contoh: Fasilitas toilet rusak"
                required>
        </div>

        <!-- Isi -->
        <div class="mb-5">
            <label class="label">
                <i class="fas fa-align-left mr-1"></i> Isi Laporan
            </label>

            <textarea
                name="isi_laporan"
                class="textarea"
                placeholder="Jelaskan kronologi, lokasi, waktu, dan detail masalah..."
                required>{{ old('isi_laporan') }}</textarea>
        </div>

        <!-- Foto -->
        <div class="mb-2">
            <label class="label">
                <i class="fas fa-image mr-1"></i> Upload Foto (Opsional)
            </label>

            <input
                type="file"
                name="foto"
                id="foto"
                accept="image/*"
                class="file-input"
                onchange="previewImage(this)">
        </div>

        <p class="info">
            Format JPG / PNG / JPEG • Maksimal 2MB
        </p>

        <div class="preview-box" id="previewBox">
            <img id="previewImg">
        </div>

        <!-- Button -->
        <div class="action">
            <button type="submit" class="btn-main">
                <i class="fas fa-paper-plane mr-2"></i>
                Kirim Pengaduan
            </button>

            <a href="{{ route('pengaduan.index') }}" class="btn-light">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>

    </form>

</div>

<script>
function previewImage(input){
    const box = document.getElementById('previewBox');
    const img = document.getElementById('previewImg');

    if(input.files && input.files[0]){
        const reader = new FileReader();

        reader.onload = function(e){
            img.src = e.target.result;
            box.style.display = 'block';
        }

        reader.readAsDataURL(input.files[0]);
    }else{
        box.style.display = 'none';
    }
}
</script>

</body>
</html>