<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class StudentAuthController extends Controller
{
    /**
     * Show student login form
     */
    public function showLoginForm()
    {
        return view('auth.student-login');
    }

    /**
     * Handle student login
     */
    public function login(Request $request)
    {
        $request->validate([
            'nim' => 'required|string',
            'password' => 'required|string',
        ], [
            'nim.required' => 'NIM harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        // Rate limiting
        $key = 'student-login:' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            
            throw ValidationException::withMessages([
                'nim' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.",
            ]);
        }

        // Find student by NIM
        $student = Student::where('nim', $request->nim)->first();

        if (!$student) {
            RateLimiter::hit($key, 60); // Lock for 1 minute
            
            return back()->withErrors([
                'nim' => 'NIM tidak ditemukan.',
            ])->withInput($request->only('nim'));
        }

        $user = $student->user;

        // Check if user exists
        if (!$user) {
            return back()->withErrors([
                'nim' => 'Data user tidak ditemukan. Hubungi admin.',
            ])->withInput($request->only('nim'));
        }

        // Verify password
        if (!Hash::check($request->password, $user->password)) {
            RateLimiter::hit($key, 60);
            
            return back()->withErrors([
                'password' => 'Password salah.',
            ])->withInput($request->only('nim'));
        }

        // Check if account is active
        if (!$user->is_active) {
            return back()->withErrors([
                'nim' => 'Akun Anda tidak aktif. Hubungi admin.',
            ])->withInput($request->only('nim'));
        }

        // Check student status
        if ($student->status !== 'AKTIF') {
            return back()->withErrors([
                'nim' => "Status mahasiswa: {$student->status}. Hubungi admin.",
            ])->withInput($request->only('nim'));
        }

        // Clear rate limiter on success
        RateLimiter::clear($key);

        // Login user
        Auth::login($user, $request->filled('remember'));

        // Update last login
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ]);

        // Regenerate session
        $request->session()->regenerate();

        // Redirect to student dashboard
        return redirect()->intended(route('student.dashboard'));
    }

    /**
     * Logout student
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

          return redirect('/')
        ->with('success', 'Anda telah berhasil logout.');
    }
}