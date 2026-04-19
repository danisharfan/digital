<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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

        return redirect()->intended(route($this->redirectToDashboard($user)));
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
        $user = Auth::user();

        abort_unless($user->role === 'admin', 403);

        return view('dashboard.admin', [
            'user' => $user,
        ]);
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
        return $user->role === 'admin' ? 'admin.dashboard' : 'siswa.dashboard';
    }
}
