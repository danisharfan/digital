<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Statistik pengaduan
        $totalPengaduan = Pengaduan::count();
        $pendingPengaduan = Pengaduan::where('status', 'pending')->count();
        $ditanggapiPengaduan = Pengaduan::where('status', 'ditanggapi')->count();
        $selesaiPengaduan = Pengaduan::where('status', 'selesai')->count();

        // Pengaduan terbaru
        $recentPengaduan = Pengaduan::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Total siswa
        $totalSiswa = User::where('role', 'siswa')->count();

        return view('dashboard.admin', compact(
            'user',
            'totalPengaduan',
            'pendingPengaduan',
            'ditanggapiPengaduan',
            'selesaiPengaduan',
            'recentPengaduan',
            'totalSiswa'
        ));
    }

    public function pengaduan(Request $request)
    {
        $query = Pengaduan::with('user');

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $pengaduan = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.pengaduan.index', compact('pengaduan'));
    }

    public function showPengaduan(Pengaduan $pengaduan)
    {
        $pengaduan->load('user');
        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'status' => 'required|in:pending,ditanggapi,selesai',
            'feedback' => 'nullable|string|max:1000'
        ]);

        $data = [
            'status' => $request->status,
        ];

        if ($request->filled('feedback')) {
            $data['feedback'] = $request->feedback;
            $data['feedback_at'] = now();
        } elseif ($request->status === 'ditanggapi' || $request->status === 'selesai') {
            $data['feedback'] = $pengaduan->feedback ?: 'Pengaduan telah diproses oleh admin.';
            $data['feedback_at'] = now();
        }

        $pengaduan->update($data);

        return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }

    public function users()
    {
        $users = User::where('role', 'siswa')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }
}