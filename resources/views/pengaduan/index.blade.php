<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Pengaduan - Pengaduan Siswa</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.4/dist/tailwind.min.css">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0d7377 0%, #14919b 25%, #00d4ff 55%, #14919b 80%, #0d7377 100%);
            background-size: 400% 400%;
            animation: bgMove 15s ease infinite;
            min-height: 100vh;
            padding: 25px;
        }

        @keyframes bgMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .wrapper {
            max-width: 1300px;
            margin: auto;
        }

        .main-card {
            background: rgba(255, 255, 255, .96);
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, .18);
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .title {
            font-size: 32px;
            font-weight: 800;
            color: #111827;
        }

        .sub {
            color: #6b7280;
            margin-top: 6px;
        }

        .btn-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 18px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            color: white;
            transition: .3s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-main {
            background: linear-gradient(135deg, #00a8cc, #00d4ff);
        }

        .btn-back {
            background: #6b7280;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 22px;
            font-weight: 500;
        }

        .table-box {
            overflow-x: auto;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 950px;
        }

        thead {
            background: #0d7377;
            color: white;
        }

        th {
            padding: 16px;
            text-align: left;
            font-size: 14px;
            font-weight: 600;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: top;
            font-size: 14px;
            color: #374151;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        .badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
        }

        .pending {
            background: #fff7d6;
            color: #d97706;
        }

        .ditanggapi {
            background: #dbeafe;
            color: #2563eb;
        }

        .selesai {
            background: #dcfce7;
            color: #166534;
        }

        .desc {
            max-width: 330px;
            line-height: 1.6;
            color: #6b7280;
        }

        .thumb {
            width: 65px;
            height: 65px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
        }

        .action {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .action a,
        .action button {
            border: none;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
        }

        .view {
            background: #eff6ff;
            color: #2563eb;
        }

        .edit {
            background: #fef3c7;
            color: #b45309;
        }

        .delete {
            background: #fee2e2;
            color: #dc2626;
        }

        .empty-box {
            text-align: center;
            padding: 70px 20px;
        }

        .empty-box i {
            font-size: 55px;
            color: #9ca3af;
            margin-bottom: 18px;
        }

        .empty-box h3 {
            font-size: 24px;
            font-weight: 700;
            color: #374151;
        }

        .empty-box p {
            color: #6b7280;
            margin: 10px 0 24px;
        }

        .pagination {
            margin-top: 22px;
        }

        @media(max-width:768px) {
            .main-card {
                padding: 22px;
            }

            .title {
                font-size: 24px;
            }

            .btn {
                width: 100%;
                text-align: center;
            }

            .btn-group {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="wrapper">
        <div class="main-card">

            <!-- Header -->
            <div class="topbar">
                <div>
                    <div class="title">Daftar Pengaduan</div>
                    <div class="sub">Kelola semua pengaduan Anda dengan rapi dan mudah</div>
                </div>

                <div class="btn-group">
                    <a href="{{ route('siswa.dashboard') }}" class="btn btn-back">
                        <i class="fas fa-arrow-left mr-2"></i>Dashboard
                    </a>

                    <a href="{{ route('pengaduan.create') }}" class="btn btn-main">
                        <i class="fas fa-plus mr-2"></i>Buat Pengaduan
                    </a>
                </div>
            </div>

            <!-- Alert -->
            @if (session('success'))
                <div class="alert-success">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Data -->
            @if ($pengaduan->count() > 0)

                <div class="table-box">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Isi Laporan</th>
                                <th>Status</th>
                                <th>Feedback</th>
                                <th>Tanggal</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengaduan as $index => $item)
                                <tr>
                                    <td>{{ $pengaduan->firstItem() + $index }}</td>

                                    <td>
                                        <strong>{{ $item->judul }}</strong>
                                    </td>

                                    <td>
                                        <div class="desc">
                                            {{ Str::limit($item->isi_laporan, 90) }}
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge {{ $item->status }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($item->feedback)
                                            <div style="max-width:200px; color:#065f46; font-size:13px;">
                                                {{ Str::limit($item->feedback, 80) }}
                                            </div>
                                            @if ($item->feedback_at)
                                                <small class="text-gray-400">
                                                    {{ $item->feedback_at->format('d M Y H:i') }}
                                                </small>
                                            @endif
                                        @else
                                            <span class="text-gray-400">Belum ada feedback</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $item->tanggal_lapor->format('d M Y') }}<br>
                                        <small>{{ $item->tanggal_lapor->format('H:i') }}</small>
                                    </td>

                                    <td>
                                        @if ($item->foto)
                                            <img src="{{ Storage::url($item->foto) }}" class="thumb">
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="action">
                                            <a href="{{ route('pengaduan.show', $item) }}" class="view">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

                <div class="pagination">
                    {{ $pengaduan->links() }}
                </div>
            @else
                <div class="empty-box">
                    <i class="fas fa-inbox"></i>
                    <h3>Belum Ada Pengaduan</h3>
                    <p>Anda belum membuat pengaduan apapun.</p>

                    <a href="{{ route('pengaduan.create') }}" class="btn btn-main">
                        <i class="fas fa-plus mr-2"></i>Buat Pengaduan Pertama
                    </a>
                </div>

            @endif

        </div>
    </div>

</body>

</html>
