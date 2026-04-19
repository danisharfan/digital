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
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap">
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

.wrapper{max-width:1400px;margin:auto;}
.card-main{
background:rgba(255,255,255,.95);
border-radius:24px;
padding:32px;
backdrop-filter:blur(15px);
box-shadow:0 25px 50px rgba(0,0,0,.15);
}

.btn-main{
background:linear-gradient(135deg,#00a8cc,#00d4ff);
color:white;
padding:10px 18px;
border-radius:12px;
font-weight:600;
text-decoration:none;
display:inline-flex;
align-items:center;
gap:8px;
}

.btn-danger{
background:#ef4444;
color:white;
padding:10px 18px;
border:none;
border-radius:12px;
font-weight:600;
cursor:pointer;
}

.btn-success{
background:#10b981;
color:white;
padding:10px 18px;
border:none;
border-radius:12px;
font-weight:600;
cursor:pointer;
}

.filter{display:flex;gap:10px;flex-wrap:wrap;margin:20px 0;}
.filter a{
padding:10px 16px;
border-radius:999px;
font-size:14px;
font-weight:600;
text-decoration:none;
}

.off{background:#f3f4f6;color:#374151;}
.on{background:linear-gradient(135deg,#00a8cc,#00d4ff);color:white;}

.list{display:grid;gap:18px;}

.item{
background:white;
border-radius:18px;
padding:22px;
border:1px solid #e5e7eb;
}

.top{
display:flex;
justify-content:space-between;
gap:15px;
margin-bottom:10px;
}

.title{font-size:20px;font-weight:700;color:#111827;}

.badge{
padding:6px 12px;
border-radius:999px;
font-size:12px;
font-weight:700;
}

.pending{background:#fef3c7;color:#d97706;}
.ditanggapi{background:#dbeafe;color:#2563eb;}
.selesai{background:#d1fae5;color:#065f46;}

.desc{color:#6b7280;font-size:14px;line-height:1.7;margin-bottom:14px;}

.meta{
display:flex;
gap:18px;
flex-wrap:wrap;
font-size:13px;
color:#6b7280;
margin-bottom:14px;
}

.bottom{
display:flex;
justify-content:space-between;
align-items:center;
flex-wrap:wrap;
gap:15px;
}

.action{
display:flex;
gap:10px;
flex-wrap:wrap;
}

textarea{
width:100%;
padding:12px;
border:1px solid #d1d5db;
border-radius:12px;
resize:none;
margin-top:10px;
}

.photo{
width:90px;
height:90px;
object-fit:cover;
border-radius:14px;
}
.status-select{
width: 160px;
padding: 10px 38px 10px 14px;
border-radius: 12px;
border: 1px solid #d1d5db;
background-color: #ffffff;
font-size: 14px;
font-weight: 600;
color: #374151;
cursor: pointer;

/* hilangkan style default browser */
appearance: none;
-webkit-appearance: none;
-moz-appearance: none;

/* arrow custom */
background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%236b7280' viewBox='0 0 20 20'%3E%3Cpath d='M5.5 7l4.5 4.5L14.5 7H5.5z'/%3E%3C/svg%3E");
background-repeat: no-repeat;
background-position: right 12px center;
background-size: 14px;

/* shadow biar gak flat */
box-shadow: 0 2px 6px rgba(0,0,0,0.06);
transition: 0.2s ease;
}

.status-select:focus{
outline: none;
border-color: #00a8cc;
box-shadow: 0 0 0 3px rgba(0,168,204,0.2);
}

</style>
</head>

<body>

<div class="wrapper">
<div class="card-main">

<!-- HEADER -->
<div class="flex justify-between items-center flex-wrap gap-4">
<div>
<h1 class="text-3xl font-bold text-gray-800">Kelola Pengaduan</h1>
<p class="text-gray-600">Pantau dan kelola semua laporan siswa</p>
</div>

<a href="{{ route('admin.dashboard') }}" class="btn-main">
<i class="fas fa-arrow-left"></i> Dashboard
</a>
</div>

@if(session('success'))
<div class="mt-5 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl">
{{ session('success') }}
</div>
@endif

<!-- FILTER -->
<div class="filter">
<a href="{{ route('admin.pengaduan.index') }}" class="{{ !request('status') ? 'on':'off' }}">Semua</a>
<a href="{{ route('admin.pengaduan.index',['status'=>'pending']) }}" class="{{ request('status')=='pending' ? 'on':'off' }}">Pending</a>
<a href="{{ route('admin.pengaduan.index',['status'=>'ditanggapi']) }}" class="{{ request('status')=='ditanggapi' ? 'on':'off' }}">Ditanggapi</a>
<a href="{{ route('admin.pengaduan.index',['status'=>'selesai']) }}" class="{{ request('status')=='selesai' ? 'on':'off' }}">Selesai</a>
</div>

@if($pengaduan->count())

<div class="list">

@foreach($pengaduan as $item)

<div class="item">

<div class="top">
<div class="title">{{ $item->judul }}</div>

<span class="badge {{ $item->status }}">
{{ ucfirst($item->status) }}
</span>
</div>

<div class="desc">
{{ Str::limit($item->isi_laporan,180) }}
</div>

<div class="meta">
<span><i class="fas fa-user"></i> {{ $item->user->nama }}</span>
<span><i class="fas fa-at"></i> {{ $item->user->username }}</span>
<span><i class="fas fa-calendar"></i> {{ $item->tanggal_lapor->format('d M Y H:i') }}</span>
</div>

@if($item->feedback)
<div class="mb-4 bg-blue-50 border border-blue-200 rounded-xl p-3 text-sm text-blue-700">
<b>Feedback Admin:</b><br>
{{ $item->feedback }}
</div>
@endif

<div class="bottom">

<div class="action">

<!-- DETAIL -->
<a href="{{ route('admin.pengaduan.show',$item->id) }}" class="btn-main">
<i class="fas fa-eye"></i> Detail
</a>

<!-- UPDATE STATUS -->
<form action="{{ route('admin.pengaduan.update-status',$item->id) }}" method="POST">
@csrf
@method('PUT')

<select name="status" class="status-select">
    <option value="pending">Pending</option>
    <option value="ditanggapi">Ditanggapi</option>
    <option value="selesai">Selesai</option>
</select>

<button class="btn-success mt-2">
<i class="fas fa-save"></i> Update
</button>
</form>

<!-- DELETE -->
<form action="{{ route('admin.pengaduan.destroy',$item->id) }}" method="POST"
onsubmit="return confirm('Hapus pengaduan ini?')">
@csrf
@method('DELETE')
<button class="btn-danger">
<i class="fas fa-trash"></i> Hapus
</button>
</form>

</div>

@if($item->foto)
<img src="{{ Storage::url($item->foto) }}" class="photo">
@endif

</div>

<!-- FEEDBACK -->
<form action="{{ route('admin.pengaduan.feedback',$item->id) }}" method="POST" class="mt-4">
@csrf
<textarea name="feedback" rows="3" placeholder="Tulis feedback ke siswa...">{{ $item->feedback }}</textarea>

<button class="btn-main mt-3">
<i class="fas fa-paper-plane"></i> Kirim Feedback
</button>
</form>

</div>

@endforeach

</div>

<div class="mt-8">
{{ $pengaduan->links() }}
</div>

@else

<div class="text-center py-20">
<i class="fas fa-inbox text-5xl text-gray-400 mb-4"></i>
<h3 class="text-xl font-bold text-gray-700">Belum ada pengaduan</h3>
<p class="text-gray-500">Semua laporan siswa akan tampil di sini</p>
</div>

@endif

</div>
</div>

</body>
</html>