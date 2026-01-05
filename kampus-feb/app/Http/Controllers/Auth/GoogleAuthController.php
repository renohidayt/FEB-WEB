<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use GuzzleHttp\Exception\ClientException;
use Exception;

class GoogleAuthController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirect()
    {
        try {
            return Socialite::driver('google')
                ->scopes(['openid', 'profile', 'email'])
                ->redirect();
        } catch (Exception $e) {
            Log::error('Google OAuth redirect error', [
                'error' => $e->getMessage()
            ]);
            
            return redirect()->route('login')
                ->with('error', 'Tidak dapat menghubungi layanan Google. Silakan coba lagi.');
        }
    }

    /**
     * Handle Google OAuth callback
     */
    public function callback()
    {
        try {
            // Ambil data user dari Google
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Validasi email verification dari Google
            if (!($googleUser->user['email_verified'] ?? false)) {
                Log::warning('Unverified email login attempt', [
                    'email' => $googleUser->getEmail()
                ]);
                
                return redirect()->route('login')
                    ->with('error', 'Email Google Anda belum terverifikasi. Silakan verifikasi email terlebih dahulu.');
            }

            // Validasi domain email (opsional - uncomment jika hanya allow domain tertentu)
            // $allowedDomains = ['yourdomain.com', 'company.com'];
            // $emailDomain = substr(strrchr($googleUser->getEmail(), "@"), 1);
            // if (!in_array($emailDomain, $allowedDomains)) {
            //     return redirect()->route('login')
            //         ->with('error', 'Hanya email dari domain perusahaan yang diizinkan.');
            // }

            // Cari admin yang sudah terdaftar berdasarkan email
            $user = User::where('email', $googleUser->getEmail())
                        ->whereIn('role', ['admin', 'super_admin'])
                        ->first();

            if (!$user) {
                // Log unauthorized access attempt
                Log::warning('Unauthorized Google login attempt', [
                    'email' => $googleUser->getEmail(),
                    'ip' => request()->ip(),
                    'user_agent' => request()->userAgent()
                ]);
                
                return redirect()->route('login')
                    ->with('error', 'Akun Google Anda tidak terdaftar sebagai admin. Silakan hubungi administrator.');
            }

            // Update user data dalam database transaction
            DB::transaction(function () use ($user, $googleUser) {
                $user->update([
                    'google_id' => $user->google_id ?? $googleUser->getId(),
                    'avatar' => $user->avatar ?? $googleUser->getAvatar(),
                    'last_login_at' => now(),
                    'last_login_ip' => request()->ip()
                ]);
            });

            // Login user dengan remember token
            Auth::login($user, true);

            // Regenerate session untuk keamanan
            request()->session()->regenerate();

            // Log successful login
            Log::info('Successful Google OAuth login', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => request()->ip()
            ]);

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang kembali, ' . $user->name . '!');

        } catch (InvalidStateException $e) {
            // CSRF/State mismatch error
            Log::error('Google OAuth state mismatch', [
                'error' => $e->getMessage(),
                'ip' => request()->ip()
            ]);
            
            return redirect()->route('login')
                ->with('error', 'Sesi login tidak valid atau telah kedaluwarsa. Silakan coba lagi.');
                
        } catch (ClientException $e) {
            // Google API error (401, 403, dll)
            Log::error('Google API client error', [
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
            
            return redirect()->route('login')
                ->with('error', 'Gagal mengakses layanan Google. Pastikan Anda memberikan izin yang diperlukan.');
                
        } catch (Exception $e) {
            // General error
            Log::error('Google OAuth callback error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => request()->ip()
            ]);
            
            return redirect()->route('login')
                ->with('error', 'Terjadi kesalahan saat login dengan Google. Silakan coba lagi atau hubungi administrator.');
        }
    }

    /**
     * Logout user
     */
    public function logout()
    {
        $user = Auth::user();
        
        // Log logout activity
        if ($user) {
            Log::info('User logged out', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => request()->ip()
            ]);
        }

        // Logout dan clear session
        Auth::logout();
        
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil logout.');
    }
}