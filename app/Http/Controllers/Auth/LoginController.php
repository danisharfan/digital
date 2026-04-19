<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'unique:users,username', 'min:3', 'max:255'],
            'nama' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,siswa'],
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'nama' => $validated['nama'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route($this->redirectToDashboard($user));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('username', $credentials['username'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['Username atau password salah.'],
            ]);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->route($this->redirectToDashboard($user));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function dashboard()
    {
        $user = Auth::user();

        return redirect()->route($this->dashboardRoute($user));
    }

    public function adminDashboard()
    {
        return app(AdminController::class)->dashboard();
    }

    public function siswaDashboard()
    {
        $user = Auth::user();

        abort_unless($user->role === 'siswa', 403);

        return view('dashboard.siswa', [
            'user' => $user,
        ]);
    }

    protected function redirectToDashboard(User $user): string
    {
        return $this->dashboardRoute($user);
    }

    protected function dashboardRoute(User $user): string
    {
        return $user->role === 'admin'
            ? 'admin.dashboard'
            : 'siswa.dashboard';
    }
}