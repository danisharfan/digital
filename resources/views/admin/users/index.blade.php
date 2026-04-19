<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kelola Siswa</title>

@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@else
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.4/dist/tailwind.min.css">
@endif

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
*{
    font-family:'Poppins',sans-serif;
}

body{
    background:linear-gradient(135deg,#0d7377 0%,#14919b 25%,#00d4ff 50%,#14919b 75%,#0d7377 100%);
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

.wrapper{
    max-width:1400px;
    margin:auto;
}

.main-card{
    background:rgba(255,255,255,.95);
    border-radius:24px;
    padding:30px;
    backdrop-filter:blur(20px);
    box-shadow:0 25px 50px rgba(0,0,0,.15);
}

.btn-main{
    background:linear-gradient(135deg,#00a8cc,#00d4ff);
    color:white;
    padding:12px 18px;
    border-radius:14px;
    font-size:14px;
    font-weight:600;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    gap:8px;
}

.btn-main:hover{
    transform:translateY(-2px);
}

.search-box{
    width:100%;
    padding:12px 16px;
    border-radius:14px;
    border:1px solid #d1d5db;
    outline:none;
}

.table-wrap{
    overflow-x:auto;
    margin-top:22px;
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:#111827;
    color:white;
}

th,td{
    padding:14px;
    text-align:left;
    font-size:14px;
    border-bottom:1px solid #f3f4f6;
}

tbody tr:hover{
    background:#f9fafb;
}

.badge{
    padding:5px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
}

.badge-admin{
    background:#fef3c7;
    color:#d97706;
}

.badge-siswa{
    background:#dbeafe;
    color:#2563eb;
}

.action{
    display:flex;
    gap:8px;
}

.btn-sm{
    padding:7px 10px;
    border-radius:10px;
    font-size:12px;
    font-weight:600;
    text-decoration:none;
}

.edit{
    background:#dbeafe;
    color:#2563eb;
}

.delete{
    background:#fee2e2;
    color:#dc2626;
    border:none;
    cursor:pointer;
}

.empty{
    text-align:center;
    padding:50px;
    color:#6b7280;
}

@media(max-width:768px){
    .main-card{
        padding:20px;
    }

    .topbar{
        flex-direction:column;
        align-items:flex-start;
    }

    .action{
        flex-direction:column;
    }
}
</style>
</head>
<body>

<div class="wrapper">
<div class="main-card">

<!-- Header -->
<div class="topbar flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Kelola Siswa</h1>
        <p class="text-gray-600 mt-1">Manajemen akun siswa dan admin</p>
    </div>

    <div class="flex gap-3 flex-wrap">
        <a href="{{ route('admin.dashboard') }}" class="btn-main">
            <i class="fas fa-arrow-left"></i>
            Dashboard
        </a>

        <a href="{{ route('admin.users.create') }}" class="btn-main">
            <i class="fas fa-plus"></i>
            Tambah User
        </a>
    </div>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl mb-5">
    {{ session('success') }}
</div>
@endif

<!-- Search -->
<form method="GET">
    <input type="text" name="search" value="{{ request('search') }}" class="search-box"
           placeholder="Cari username / nama user...">
</form>

<!-- Table -->
<div class="table-wrap">
<table>

<thead>
<tr>
    <th>No</th>
    <th>Username</th>
    <th>Nama</th>
    <th>Role</th>
    <th>Tanggal Daftar</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>

@forelse($users as $index => $user)
<tr>
    <td>{{ $users->firstItem() + $index }}</td>
    <td>{{ $user->username }}</td>
    <td>{{ $user->nama }}</td>
    <td>
        <span class="badge {{ $user->role == 'admin' ? 'badge-admin' : 'badge-siswa' }}">
            {{ ucfirst($user->role) }}
        </span>
    </td>
    <td>{{ $user->created_at->format('d M Y') }}</td>
    <td>
        <div class="action">

            <a href="{{ route('admin.users.edit',$user->id) }}" class="btn-sm edit">
                <i class="fas fa-edit"></i> Edit
            </a>

            <form action="{{ route('admin.users.destroy',$user->id) }}" method="POST"
                  onsubmit="return confirm('Yakin hapus user ini?')">
                @csrf
                @method('DELETE')

                <button class="btn-sm delete">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>

        </div>
    </td>
</tr>

@empty
<tr>
    <td colspan="6" class="empty">
        Tidak ada data user
    </td>
</tr>
@endforelse

</tbody>
</table>
</div>

<div class="mt-6">
    {{ $users->links() }}
</div>

</div>
</div>

</body>
</html>