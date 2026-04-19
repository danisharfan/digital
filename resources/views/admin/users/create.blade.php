<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tambah User</title>

@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@else
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.4/dist/tailwind.min.css">
@endif

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

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
    padding:30px 16px;
    display:flex;
    justify-content:center;
    align-items:center;
}

@keyframes bgMove{
    0%{background-position:0% 50%;}
    50%{background-position:100% 50%;}
    100%{background-position:0% 50%;}
}

.wrapper{
    width:100%;
    max-width:760px;
}

.card{
    background:rgba(255,255,255,.97);
    border-radius:24px;
    padding:34px;
    box-shadow:0 25px 50px rgba(0,0,0,.18);
}

.title{
    font-size:30px;
    font-weight:700;
    color:#0d7377;
    margin-bottom:6px;
}

.sub{
    font-size:14px;
    color:#6b7280;
    margin-bottom:24px;
}

.row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:18px;
    margin-bottom:18px;
}

.group{
    width:100%;
}

label{
    display:block;
    margin-bottom:8px;
    font-size:14px;
    font-weight:600;
    color:#111827;
}

.input{
    width:100%;
    height:48px;
    padding:0 15px;
    border:1px solid #d1d5db;
    border-radius:14px;
    outline:none;
    font-size:14px;
    background:#fff;
    transition:.2s;
}

.input:focus{
    border-color:#00bcd4;
    box-shadow:0 0 0 4px rgba(0,188,212,.12);
}

.actions{
    margin-top:28px;
    display:flex;
    gap:14px;
    flex-wrap:wrap;
}

.btn{
    min-width:150px;
    height:48px;
    border:none;
    border-radius:14px;
    font-size:14px;
    font-weight:600;
    cursor:pointer;
    text-decoration:none;
    display:flex;
    align-items:center;
    justify-content:center;
    transition:.2s;
}

.btn-back{
    background:#eef2f7;
    color:#374151;
}

.btn-back:hover{
    background:#e5e7eb;
}

.btn-save{
    color:#fff;
    background:linear-gradient(135deg,#00a8cc,#00d4ff);
    box-shadow:0 10px 20px rgba(0,168,204,.25);
}

.btn-save:hover{
    transform:translateY(-2px);
}

@media(max-width:768px){

    body{
        padding:20px 12px;
        align-items:flex-start;
    }

    .card{
        padding:24px;
        border-radius:20px;
    }

    .title{
        font-size:25px;
    }

    .row{
        grid-template-columns:1fr;
        gap:16px;
        margin-bottom:16px;
    }

    .actions{
        flex-direction:column;
    }

    .btn{
        width:100%;
    }
}
</style>
</head>
<body>

<div class="wrapper">
<div class="card">

    <h1 class="title">Tambah User</h1>
    <p class="sub">Buat akun baru admin atau siswa</p>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="group">
                <label>Username</label>
                <input type="text" name="username" value="{{ old('username') }}" class="input">
            </div>

            <div class="group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="input">
            </div>
        </div>

        <div class="row">
            <div class="group">
                <label>Password</label>
                <input type="password" name="password" class="input">
            </div>

            <div class="group">
                <label>Role</label>
                <select name="role" class="input">
                    <option value="siswa">Siswa</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
        </div>

        <div class="actions">
            <a href="{{ route('admin.users.index') }}" class="btn btn-back">
                Kembali
            </a>

            <button type="submit" class="btn btn-save">
                Simpan User
            </button>
        </div>

    </form>

</div>
</div>

</body>
</html>