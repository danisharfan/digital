<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        $user = Auth::user();

        $totalPengaduan       = Pengaduan::count();
        $pendingPengaduan     = Pengaduan::where('status', 'pending')->count();
        $ditanggapiPengaduan  = Pengaduan::where('status', 'ditanggapi')->count();
        $selesaiPengaduan     = Pengaduan::where('status', 'selesai')->count();

        $recentPengaduan = Pengaduan::with('user')
            ->latest()
            ->take(5)
            ->get();

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


    /*
    |--------------------------------------------------------------------------
    | KELOLA PENGADUAN
    |--------------------------------------------------------------------------
    */

    public function pengaduan(Request $request)
    {
        $query = Pengaduan::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengaduan = $query->latest()->paginate(10);

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
        ]);

        $pengaduan->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }


    public function feedback(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'feedback' => 'required|string|max:1000',
        ]);

        $pengaduan->update([
            'feedback'    => $request->feedback,
            'feedback_at' => now(),
            'status'      => 'ditanggapi',
        ]);

        return back()->with('success', 'Feedback berhasil dikirim.');
    }


    public function destroyPengaduan(Pengaduan $pengaduan)
    {
        if ($pengaduan->foto) {
            Storage::disk('public')->delete($pengaduan->foto);
        }

        $pengaduan->delete();

        return back()->with('success', 'Pengaduan berhasil dihapus.');
    }


    /*
    |--------------------------------------------------------------------------
    | KELOLA USERS
    |--------------------------------------------------------------------------
    */

    public function users(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('username', 'like', '%' . $request->search . '%')
                  ->orWhere('nama', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }


    public function createUser()
    {
        return view('admin.users.create');
    }


    public function storeUser(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'nama'     => 'required|max:255',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,siswa',
        ]);

        User::create([
            'username' => $request->username,
            'nama'     => $request->nama,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }


    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }


    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
            'nama'     => 'required|max:255',
            'role'     => 'required|in:admin,siswa',
        ]);

        $data = [
            'username' => $request->username,
            'nama'     => $request->nama,
            'role'     => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }


    public function destroyUser(User $user)
    {
        if ($user->id == Auth::id()) {
            return back()->with('success', 'Tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}