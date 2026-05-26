<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuditLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return match (Auth::user()->role) {
                'admin', 'kepala_desa' => redirect()->route('admin.dashboard'),
                default => redirect()->route('user.dashboard'),
            };
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Rate limiting - max 5 attempts
        $key = 'login-attempts:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.");
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            RateLimiter::clear($key);

            // PERBAIKAN: Hanya regenerate session, JANGAN invalidate!
            $request->session()->regenerate();

            session(['last_activity_time' => time()]);

            AuditLogService::log('Login', 'User login berhasil');

            // Redirect sesuai role
            return match (Auth::user()->role) {
                'admin' => redirect()->intended(route('admin.dashboard')),
                'kepala_desa' => redirect()->intended(route('admin.dashboard')),
                'user' => redirect()->intended(route('user.dashboard')),
                default => redirect()->route('login'),
            };
        }

        RateLimiter::hit($key, 300);

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        AuditLogService::log('Logout', 'User logout');

        Auth::logout();

        // invalidate() dan regenerateToken() HANYA saat LOGOUT
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }
}
