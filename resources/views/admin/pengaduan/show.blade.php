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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
*{font-family:'Poppins',sans-serif;}

body{
    background:linear-gradient(135deg,#0d7377,#14919b,#00d4ff,#14919b,#0d7377);
    background-size:400% 400%;
    animation:bgMove 15s ease infinite;
    min-height:100vh;
    padding:20px;
}

@keyframes bgMove{
    0%{background-position:0% 50%;}
    50%{background-position:100% 50%;}
    100%{background-position:0% 50%;}
}

.card{
    background:rgba(255,255,255,.96);
    border-radius:24px;
    padding:30px;
    box-shadow:0 20px 45px rgba(0,0,0,.18);
}

.badge{
    padding:6px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
}

.pending{background:#fef3c7;color:#d97706;}
.ditanggapi{background:#dbeafe;color:#2563eb;}
.selesai{background:#dcfce7;color:#166534;}

.btn{
    padding:10px 16px;
    border-radius:10px;
    font-weight:600;
    color:white;
}

.btn-primary{background:linear-gradient(135deg,#00a8cc,#00d4ff);}
.btn-secondary{background:#6b7280;}

textarea,select{
    width:100%;
    padding:10px;
    border-radius:10px;
    border:1px solid #d1d5db;
}
</style>
</head>

<body>

<div class="max-w-6xl mx-auto">

<div class="card">

<!-- HEADER -->
<div class="flex justify-between items-center mb-6 flex-wrap gap-3">
    <div>
        <h1 class="text-2xl font-bold">Detail Pengaduan</h1>
        <p class="text-gray-500">Kelola laporan siswa</p>
    </div>

    <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<div class="grid md:grid-cols-3 gap-6">

<!-- LEFT -->
<div class="md:col-span-2 space-y-4">

    <!-- CARD INFO -->
    <div class="border rounded-xl p-4">
        <div class="flex justify-between items-start">
            <h2 class="text-xl font-semibold">{{ $pengaduan->judul }}</h2>
            <span class="badge {{ $pengaduan->status }}">
                {{ ucfirst($pengaduan->status) }}
            </span>
        </div>

        <div class="text-sm text-gray-500 mt-3 space-y-1">
            <div>Siswa: {{ $pengaduan->user->nama }}</div>
            <div>Tanggal: {{ $pengaduan->tanggal_lapor->format('d M Y H:i') }}</div>
        </div>
    </div>

    <!-- ISI -->
    <div class="bg-gray-50 p-4 rounded-xl">
        <h3 class="font-semibold mb-2">Isi Laporan</h3>
        <p class="text-gray-700 whitespace-pre-line">
            {{ $pengaduan->isi_laporan }}
        </p>
    </div>

    <!-- FOTO -->
    @if($pengaduan->foto)
    <div class="border rounded-xl p-4">
        <h3 class="font-semibold mb-2">Foto</h3>
        <img src="{{ Storage::url($pengaduan->foto) }}" class="rounded-lg">
    </div>
    @endif

    <!-- FEEDBACK -->
    @if($pengaduan->feedback)
    <div class="bg-blue-50 p-4 rounded-xl border">
        <h3 class="font-semibold mb-2 text-blue-700">
            <i class="fas fa-reply mr-1"></i> Feedback Admin
        </h3>

        <p class="text-gray-700">
            {{ $pengaduan->feedback }}
        </p>

        <small class="text-gray-500">
            {{ $pengaduan->feedback_at?->format('d M Y H:i') }}
        </small>
    </div>
    @endif

</div>

<!-- RIGHT -->
<div class="border rounded-xl p-4 space-y-4">

    <h3 class="font-semibold">Kelola</h3>

    <form action="{{ route('admin.pengaduan.update-status',$pengaduan) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Status</label>
        <select name="status">
            <option value="pending">Pending</option>
            <option value="ditanggapi">Ditanggapi</option>
            <option value="selesai">Selesai</option>
        </select>

        <label class="mt-3 block">Feedback</label>
        <textarea name="feedback" rows="5">{{ $pengaduan->feedback }}</textarea>

        <button class="btn btn-primary w-full mt-4">
            Simpan
        </button>
    </form>

</div>

</div>

</div>
</div>

</body>
</html>