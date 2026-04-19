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
* {
    font-family: 'Poppins', sans-serif;
    box-sizing: border-box;
}

body {
    background: linear-gradient(135deg, #0d7377, #14919b, #00d4ff, #14919b, #0d7377);
    background-size: 400% 400%;
    animation: bgMove 15s ease infinite;
    min-height: 100vh;
    padding: 24px 16px;
}

@keyframes bgMove {
    0%   { background-position: 0% 50%; }
    50%  { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* ── Page wrapper ── */
.page-wrapper {
    max-width: 1024px;
    margin: 0 auto;
}

/* ── Card ── */
.card {
    background: rgba(255, 255, 255, 0.97);
    border-radius: 20px;
    padding: 28px;
    box-shadow: 0 16px 40px rgba(0, 0, 0, 0.15);
}

/* ── Page header ── */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 24px;
}

.page-title {
    font-size: 22px;
    font-weight: 700;
    color: #111827;
    margin: 0;
}

.page-subtitle {
    font-size: 13px;
    color: #6b7280;
    margin: 2px 0 0;
}

/* ── Alert ── */
.alert-success {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 13px;
    margin-bottom: 20px;
}

/* ── Layout grid ── */
.layout-grid {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 20px;
    align-items: start;
}

@media (max-width: 768px) {
    .layout-grid {
        grid-template-columns: 1fr;
    }
}

/* ── Section cards ── */
.section-card {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 18px;
}

.section-card + .section-card {
    margin-top: 14px;
}

.section-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: #9ca3af;
    margin-bottom: 10px;
}

/* ── Pengaduan info header ── */
.pengaduan-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 14px;
}

.pengaduan-judul {
    font-size: 17px;
    font-weight: 700;
    color: #111827;
    line-height: 1.4;
}

.meta-list {
    display: grid;
    grid-template-columns: auto 1fr;
    gap: 5px 14px;
    font-size: 13px;
    color: #374151;
    border-top: 1px solid #e5e7eb;
    padding-top: 12px;
}

.meta-label {
    color: #9ca3af;
    font-weight: 500;
}

/* ── Badge ── */
.badge {
    flex-shrink: 0;
    display: inline-block;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 999px;
}

.badge-pending    { background: #fef3c7; color: #92400e; }
.badge-ditanggapi { background: #dbeafe; color: #1e40af; }
.badge-selesai    { background: #dcfce7; color: #166534; }

/* ── Isi laporan ── */
.isi-laporan {
    font-size: 14px;
    color: #374151;
    line-height: 1.75;
    white-space: pre-line;
}

/* ── Foto ── */
.foto-img {
    width: 100%;
    border-radius: 10px;
    display: block;
}

/* ── Feedback admin ── */
.feedback-wrapper {
    border-left: 3px solid #3b82f6;
    padding-left: 14px;
}

.feedback-text {
    font-size: 14px;
    color: #374151;
    line-height: 1.7;
    margin-bottom: 6px;
}

.feedback-time {
    font-size: 12px;
    color: #9ca3af;
}

/* ── Kelola panel ── */
.panel-card {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 20px;
    position: sticky;
    top: 20px;
}

.panel-title {
    font-size: 14px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 18px;
}

.form-group {
    margin-bottom: 16px;
}

.form-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #6b7280;
    margin-bottom: 6px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

select,
textarea {
    width: 100%;
    padding: 9px 12px;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    font-size: 13px;
    font-family: 'Poppins', sans-serif;
    color: #111827;
    background: #fff;
    outline: none;
    transition: border-color 0.15s, box-shadow 0.15s;
    resize: vertical;
}

select:focus,
textarea:focus {
    border-color: #00a8cc;
    box-shadow: 0 0 0 3px rgba(0, 168, 204, 0.15);
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 10px 16px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    border: none;
    transition: opacity 0.15s;
}

.btn:hover { opacity: 0.88; }

.btn-primary {
    background: linear-gradient(135deg, #00a8cc, #00d4ff);
    color: #fff;
    width: 100%;
}

.btn-secondary {
    background: #6b7280;
    color: #fff;
    font-size: 13px;
    padding: 8px 14px;
}
</style>
</head>

<body>
<div class="page-wrapper">
<div class="card">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Pengaduan</h1>
            <p class="page-subtitle">Kelola laporan siswa</p>
        </div>

        <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Flash message --}}
    @if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle mr-1"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- Main layout --}}
    <div class="layout-grid">

        {{-- ── Kolom kiri: detail pengaduan ── --}}
        <div>

            {{-- Info utama --}}
            <div class="section-card">
                <div class="pengaduan-header">
                    <h2 class="pengaduan-judul">{{ $pengaduan->judul }}</h2>
                    <span class="badge badge-{{ $pengaduan->status }}">
                        {{ ucfirst($pengaduan->status) }}
                    </span>
                </div>
                <div class="meta-list">
                    <span class="meta-label">Siswa</span>
                    <span>{{ $pengaduan->user->nama }}</span>

                    <span class="meta-label">Tanggal</span>
                    <span>{{ $pengaduan->tanggal_lapor->format('d M Y, H:i') }}</span>
                </div>
            </div>

            {{-- Isi laporan --}}
            <div class="section-card">
                <p class="section-label">Isi Laporan</p>
                <p class="isi-laporan">{{ $pengaduan->isi_laporan }}</p>
            </div>

            {{-- Foto (opsional) --}}
            @if($pengaduan->foto)
            <div class="section-card">
                <p class="section-label">Foto Lampiran</p>
                <img
                    src="{{ Storage::url($pengaduan->foto) }}"
                    alt="Foto pengaduan"
                    class="foto-img"
                >
            </div>
            @endif

            {{-- Feedback admin (opsional) --}}
            @if($pengaduan->feedback)
            <div class="section-card">
                <p class="section-label">Feedback Admin</p>
                <div class="feedback-wrapper">
                    <p class="feedback-text">{{ $pengaduan->feedback }}</p>
                    <span class="feedback-time">
                        {{ $pengaduan->feedback_at?->format('d M Y, H:i') }}
                    </span>
                </div>
            </div>
            @endif

        </div>

        {{-- ── Kolom kanan: panel kelola ── --}}
        <div class="panel-card">
            <p class="panel-title">Kelola Pengaduan</p>

            <form action="{{ route('admin.pengaduan.update-status', $pengaduan) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="status">Status</label>
                    <select name="status" id="status">
                        <option value="pending"    {{ $pengaduan->status === 'pending'    ? 'selected' : '' }}>Pending</option>
                        <option value="ditanggapi" {{ $pengaduan->status === 'ditanggapi' ? 'selected' : '' }}>Ditanggapi</option>
                        <option value="selesai"    {{ $pengaduan->status === 'selesai'    ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="feedback">Feedback untuk Siswa</label>
                    <textarea name="feedback" id="feedback" rows="6" placeholder="Tulis tanggapan...">{{ $pengaduan->feedback }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </form>
        </div>

    </div>

</div>
</div>
</body>
</html>