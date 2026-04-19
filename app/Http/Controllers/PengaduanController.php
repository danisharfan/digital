<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduan = Pengaduan::where('id_user', Auth::id())
            ->latest()
            ->paginate(10);

        return view('pengaduan.index', compact('pengaduan'));
    }

    public function create()
    {
        return view('pengaduan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_laporan' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // default null kalau tidak upload
        $path = null;

        // upload foto ke storage/app/public/pengaduan
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('pengaduan', 'public');
        }

        Pengaduan::create([
            'id_user' => Auth::id(),
            'judul' => $request->judul,
            'isi_laporan' => $request->isi_laporan,
            'foto' => $path,
            'tanggal_lapor' => now(),
            'status' => 'pending'
        ]);

        return redirect()->route('pengaduan.index')
            ->with('success', 'Pengaduan berhasil dibuat');
    }

    public function show(Pengaduan $pengaduan)
    {
        if ($pengaduan->id_user != Auth::id()) {
            abort(403);
        }

        return view('pengaduan.show', compact('pengaduan'));
    }

    public function edit(Pengaduan $pengaduan)
    {
        abort(403);
    }

    public function update(Request $request, Pengaduan $pengaduan)
    {
        abort(403);
    }

    public function destroy(Pengaduan $pengaduan)
    {
        abort(403);
    }
}