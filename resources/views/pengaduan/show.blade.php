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
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
*{
    font-family:'Poppins',sans-serif;
}

body{
    background:linear-gradient(135deg,#0d7377 0%,#14919b 30%,#00d4ff 60%,#14919b 100%);
    background-size:400% 400%;
    animation:bgMove 15s ease infinite;
    min-height:100vh;
    padding:25px;
}

@keyframes bgMove{
    0%{background-position:0% 50%;}
    50%{background-position:100% 50%;}
    100%{background-position:0% 50%;}
}

.wrapper{
    max-width:1200px;
    margin:auto;
}

.card-main{
    background:rgba(255,255,255,.96);
    border-radius:24px;
    padding:35px;
    box-shadow:0 25px 45px rgba(0,0,0,.15);
}

.top-head{
    display:flex;
    justify-content:space-between;
    gap:20px;
    flex-wrap:wrap;
    margin-bottom:28px;
}

.title{
    font-size:32px;
    font-weight:800;
    color:#111827;
}

.sub{
    color:#6b7280;
    margin-top:5px;
}

.btn-group{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.btn{
    padding:12px 18px;
    border-radius:12px;
    color:#fff;
    text-decoration:none;
    font-weight:600;
    font-size:14px;
    transition:.3s;
}

.btn:hover{
    transform:translateY(-2px);
}

.btn-back{background:#6b7280;}
.btn-edit{background:#f59e0b;}
.btn-delete{background:#ef4444;border:none;cursor:pointer;}

.grid-layout{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:24px;
}

.panel{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:18px;
    padding:24px;
}

.section-title{
    font-size:20px;
    font-weight:700;
    color:#111827;
    margin-bottom:18px;
}

.badge{
    display:inline-block;
    padding:6px 14px;
    border-radius:30px;
    font-size:13px;
    font-weight:700;
}

.pending{background:#fff7d6;color:#d97706;}
.ditanggapi{background:#dbeafe;color:#2563eb;}
.selesai{background:#dcfce7;color:#166534;}

.table-info{
    width:100%;
    border-collapse:collapse;
}

.table-info tr{
    border-bottom:1px solid #f1f5f9;
}

.table-info td{
    padding:12px 0;
    vertical-align:top;
}

.table-info td:first-child{
    width:40%;
    color:#6b7280;
    font-weight:500;
}

.desc-box{
    background:#f8fafc;
    border-left:5px solid #00a8cc;
    padding:18px;
    border-radius:12px;
    color:#374151;
    line-height:1.8;
}

.image-box{
    background:#f9fafb;
    border:1px solid #e5e7eb;
    border-radius:16px;
    padding:14px;
    text-align:center;
}

.image-box img{
    max-width:100%;
    border-radius:14px;
    max-height:430px;
    object-fit:cover;
}

@media(max-width:900px){
    .grid-layout{
        grid-template-columns:1fr;
    }
}

@media(max-width:600px){
    .card-main{
        padding:20px;
    }

    .title{
        font-size:24px;
    }

    .btn{
        width:100%;
        text-align:center;
    }

    .btn-group{
        width:100%;
    }
}
</style>
</head>

<body>

<div class="wrapper">
<div class="card-main">

    <!-- Header -->
    <div class="top-head">
        <div>
            <div class="title">Detail Pengaduan</div>
            <div class="sub">Lihat informasi lengkap laporan pengaduan Anda</div>
        </div>

        <div class="btn-group">
            <a href="{{ route('pengaduan.index') }}" class="btn btn-back">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="grid-layout">

        <!-- Kiri -->
        <div class="space-y-6">

            <div class="panel">
                <div class="section-title">
                    <i class="fas fa-file-alt text-cyan-600 mr-2"></i>
                    Judul Pengaduan
                </div>

                <h2 class="text-2xl font-bold text-gray-800 mb-5">
                    {{ $pengaduan->judul }}
                </h2>

                <div class="section-title text-lg mb-3">
                    Isi Laporan
                </div>

                <div class="desc-box">
                    {{ $pengaduan->isi_laporan }}
                </div>
            </div>

            @if($pengaduan->foto)
            <div class="panel">
                <div class="section-title">
                    <i class="fas fa-image text-cyan-600 mr-2"></i>
                    Bukti Foto
                </div>

                <div class="image-box">
                    <img src="{{ Storage::url($pengaduan->foto) }}" alt="Foto Pengaduan">
                </div>
            </div>
            @endif

        </div>

        <!-- Kanan -->
        <div>

            <div class="panel">
                <div class="section-title">
                    <i class="fas fa-circle-info text-cyan-600 mr-2"></i>
                    Informasi
                </div>

                <table class="table-info">
                    <tr>
                        <td>Status</td>
                        <td>
                            <span class="badge {{ $pengaduan->status }}">
                                {{ ucfirst($pengaduan->status) }}
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td>Tanggal Lapor</td>
                        <td>{{ $pengaduan->tanggal_lapor->format('d M Y H:i') }}</td>
                    </tr>

                    <tr>
                        <td>Dibuat</td>
                        <td>{{ $pengaduan->created_at->format('d M Y H:i') }}</td>
                    </tr>

                    <tr>
                        <td>Terakhir Update</td>
                        <td>{{ $pengaduan->updated_at->format('d M Y H:i') }}</td>
                    </tr>

                    @if($pengaduan->feedback)
                    <tr>
                        <td>Feedback Admin</td>
                        <td>{{ $pengaduan->feedback }}</td>
                    </tr>
                    @endif
                </table>
            </div>

        </div>

    </div>

</div>
</div>

</body>
</html>