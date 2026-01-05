<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomAuthController extends Controller
{
    /**
     * Login with NIM or Email
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string', // Bisa NIM atau Email
            'password' => 'required|string',
        ]);

        $loginField = $request->input('login');
        $password = $request->input('password');

        // Check if login field is NIM (numeric) or Email
        if (is_numeric($loginField)) {
            // Login dengan NIM
            $student = Student::where('nim', $loginField)->first();
            
            if (!$student) {
                return back()->withErrors([
                    'login' => 'NIM tidak ditemukan.',
                ])->withInput($request->only('login'));
            }

            $user = $student->user;

        } else {
            // Login dengan Email
            $user = User::where('email', $loginField)->first();
        }

        // Check if user exists
        if (!$user) {
            return back()->withErrors([
                'login' => 'Kredensial tidak valid.',
            ])->withInput($request->only('login'));
        }

        // Check password
        if (!Hash::check($password, $user->password)) {
            return back()->withErrors([
                'login' => 'Password salah.',
            ])->withInput($request->only('login'));
        }

        // Check if user is active
        if (!$user->is_active) {
            return back()->withErrors([
                'login' => 'Akun Anda tidak aktif. Hubungi admin.',
            ])->withInput($request->only('login'));
        }

        // Login success
        Auth::login($user, $request->filled('remember'));
        
        // Update last login
        $user->updateLastLogin();

        $request->session()->regenerate();

        // Redirect based on role
        if ($user->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('student.dashboard'));
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}