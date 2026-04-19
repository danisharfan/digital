<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard Siswa</title>

@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@else
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.4/dist/tailwind.min.css">
@endif

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    min-height:100vh;
    background:linear-gradient(135deg,#0d7377,#14919b,#00d4ff,#14919b,#0d7377);
    background-size:400% 400%;
    animation:bgMove 15s ease infinite;
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

.topbar{
    background:rgba(255,255,255,.95);
    border-radius:24px;
    padding:28px;
    box-shadow:0 20px 40px rgba(0,0,0,.12);
    margin-bottom:24px;
}

.badge{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:8px 16px;
    border-radius:999px;
    background:#ecfeff;
    color:#0d7377;
    font-size:13px;
    font-weight:600;
    margin-bottom:14px;
}

.title{
    font-size:34px;
    font-weight:800;
    color:#111827;
    margin-bottom:6px;
}

.sub{
    color:#6b7280;
    font-size:15px;
}

.grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
    margin-bottom:24px;
}

.card{
    background:rgba(255,255,255,.95);
    border-radius:22px;
    padding:24px;
    box-shadow:0 20px 35px rgba(0,0,0,.10);
}

.icon{
    width:60px;
    height:60px;
    border-radius:18px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    font-size:24px;
    margin-bottom:18px;
}

.blue{background:linear-gradient(135deg,#06b6d4,#3b82f6);}
.green{background:linear-gradient(135deg,#10b981,#22c55e);}
.orange{background:linear-gradient(135deg,#f59e0b,#f97316);}

.card h3{
    font-size:20px;
    font-weight:700;
    margin-bottom:8px;
    color:#111827;
}

.card p{
    color:#6b7280;
    font-size:14px;
    margin-bottom:18px;
}

.btn{
    display:inline-block;
    width:100%;
    text-align:center;
    padding:13px;
    border-radius:14px;
    font-size:14px;
    font-weight:600;
    text-decoration:none;
    color:#fff;
    background:linear-gradient(135deg,#00a8cc,#00d4ff);
    transition:.25s;
}

.btn:hover{
    transform:translateY(-3px);
    box-shadow:0 12px 25px rgba(0,168,204,.25);
}

.stats{
    background:rgba(255,255,255,.95);
    border-radius:24px;
    padding:28px;
    box-shadow:0 20px 35px rgba(0,0,0,.10);
    margin-bottom:24px;
}

.stats h2{
    font-size:24px;
    font-weight:700;
    margin-bottom:22px;
    color:#111827;
}

.stat-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:18px;
}

.stat{
    border-radius:18px;
    padding:20px;
    text-align:center;
}

.pending{background:#fef9c3;}
.reply{background:#dbeafe;}
.done{background:#dcfce7;}

.stat i{
    font-size:24px;
    margin-bottom:10px;
}

.stat h4{
    font-size:14px;
    margin-bottom:8px;
    color:#374151;
}

.stat .num{
    font-size:32px;
    font-weight:800;
}

.logout{
    text-align:center;
}

.logout button{
    border:none;
    padding:14px 26px;
    border-radius:14px;
    background:#ffffff;
    color:#111827;
    font-weight:600;
    cursor:pointer;
    transition:.2s;
}

.logout button:hover{
    transform:translateY(-2px);
}

@media(max-width:900px){
    .grid,.stat-grid{
        grid-template-columns:1fr;
    }

    .title{
        font-size:28px;
    }
}
</style>
</head>

<body>

<div class="wrapper">

    <!-- Header -->
    <div class="topbar">
        <div class="badge">
            <i class="fas fa-user-graduate"></i> Dashboard Siswa
        </div>

        <div class="title">
            Halo, {{ $user->nama }} 👋
        </div>

        <div class="sub">
            Selamat datang kembali. Kelola pengaduan sekolah dengan mudah.
        </div>
    </div>

    <!-- Menu -->
    <div class="grid">

        <div class="card">
            <div class="icon blue">
                <i class="fas fa-plus"></i>
            </div>
            <h3>Buat Pengaduan</h3>
            <p>Kirim laporan baru secara cepat dan detail.</p>

            <a href="{{ route('pengaduan.create') }}" class="btn">
                Buat Sekarang
            </a>
        </div>

        <div class="card">
            <div class="icon green">
                <i class="fas fa-list"></i>
            </div>
            <h3>Pengaduan Saya</h3>
            <p>Lihat semua riwayat laporan yang pernah dibuat.</p>

            <a href="{{ route('pengaduan.index') }}" class="btn">
                Lihat Data
            </a>
        </div>

        <div class="card">
            <div class="icon orange">
                <i class="fas fa-bell"></i>
            </div>
            <h3>Status Terbaru</h3>
            <p>Pantau proses penanganan pengaduan Anda.</p>

            <a href="{{ route('pengaduan.index') }}" class="btn">
                Cek Status
            </a>
        </div>

    </div>

    <!-- Statistik -->
    <div class="stats">
        <h2>Statistik Pengaduan</h2>

        <div class="stat-grid">

            <div class="stat pending">
                <i class="fas fa-clock text-yellow-600"></i>
                <h4>Pending</h4>
                <div class="num text-yellow-700">
                    {{ \App\Models\Pengaduan::where('id_user',$user->id)->where('status','pending')->count() }}
                </div>
            </div>

            <div class="stat reply">
                <i class="fas fa-reply text-blue-600"></i>
                <h4>Ditanggapi</h4>
                <div class="num text-blue-700">
                    {{ \App\Models\Pengaduan::where('id_user',$user->id)->where('status','ditanggapi')->count() }}
                </div>
            </div>

            <div class="stat done">
                <i class="fas fa-check-circle text-green-600"></i>
                <h4>Selesai</h4>
                <div class="num text-green-700">
                    {{ \App\Models\Pengaduan::where('id_user',$user->id)->where('status','selesai')->count() }}
                </div>
            </div>

        </div>
    </div>

    <!-- Logout -->
    <div class="logout">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">
                <i class="fas fa-sign-out-alt mr-2"></i> Keluar
            </button>
        </form>
    </div>

</div>

</body>
</html>