<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard Siswa - Pengaduan Siswa</title>
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.4/dist/tailwind.min.css">
        @endif
    </head>
    <body class="min-h-screen bg-[#FDFDFC] text-[#1b1b18] flex items-center justify-center p-6">
        <div class="w-full max-w-2xl rounded-3xl border border-gray-200 bg-white p-8 shadow-sm">
            <div class="flex items-center justify-between gap-4 pb-6 border-b border-gray-200">
                <div>
                    <h1 class="text-2xl font-semibold">Dashboard Siswa</h1>
                    <p class="text-sm text-gray-600">Halo, {{ $user->nama }} ({{ $user->username }})</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-xl bg-[#1b1b18] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#42413f]">
                        Keluar
                    </button>
                </form>
            </div>

            <div class="mt-6 space-y-4 text-gray-700">
                <p>Ini adalah panel siswa. Di sini Anda dapat membuat pengaduan dan memeriksa status pengaduan Anda.</p>

                <div class="rounded-2xl bg-gray-50 p-6 text-sm text-gray-700">
                    <p class="font-medium">Fitur siswa:</p>
                    <ul class="mt-3 list-disc space-y-2 pl-5">
                        <li>Buat pengaduan baru.</li>
                        <li>Lihat status pengaduan Anda.</li>
                        <li>Periksa riwayat pengaduan dan tanggapan.</li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>
