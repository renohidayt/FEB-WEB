<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('assets/img/logo/logo.png') }}" type="image/x-icon">
<link rel="shortcut icon" href="{{ asset('assets/img/logo/logo.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-800: #1e293b;
            --slate-900: #0f172a;
            --orange-500: #f97316;
            --orange-600: #ea580c;
            --orange-700: #c2410c;
        }

        body {
            background: linear-gradient(135deg, var(--slate-800) 0%, var(--slate-900) 50%, #1a1a2e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            max-width: 450px;
            width: 100%;
        }

        .logo-box {
            background: white;
            width: 100px;
            height: 100px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            padding: 15px;
        }

        .logo-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .app-title {
            color: white;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .app-subtitle {
            color: var(--slate-200);
            font-size: 0.95rem;
            margin-bottom: 0;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--orange-600) 0%, var(--orange-500) 100%);
        }

        .alert-custom {
            border-radius: 10px;
            border: none;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .google-btn {
            width: 100%;
            padding: 0.9rem 1.5rem;
            background: white;
            border: 2px solid var(--slate-200);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            font-weight: 500;
            color: var(--slate-700);
            transition: all 0.2s;
            text-decoration: none;
        }

        .google-btn:hover {
            border-color: var(--slate-300);
            background: var(--slate-50);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--slate-200);
        }

        .divider span {
            padding: 0 1rem;
            color: var(--slate-600);
            font-size: 0.875rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--slate-700);
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .form-control-custom {
            padding: 0.9rem 1rem 0.9rem 3rem;
            border: 2px solid var(--slate-200);
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-control-custom:focus {
            border-color: var(--orange-500);
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
            outline: none;
        }

        .form-control-custom.is-invalid {
            border-color: #dc3545;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--slate-600);
            font-size: 1rem;
        }

        .btn-login {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(135deg, var(--orange-600) 0%, var(--orange-500) 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, var(--orange-700) 0%, var(--orange-600) 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);
        }

        .form-check-input {
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid var(--slate-300);
        }

        .form-check-input:checked {
            background-color: var(--orange-500);
            border-color: var(--orange-500);
        }

        .footer-link {
            color: var(--slate-600);
            font-size: 0.9rem;
        }

        .footer-link a {
            color: var(--orange-600);
            text-decoration: none;
            font-weight: 600;
        }

        .footer-link a:hover {
            color: var(--orange-700);
            text-decoration: underline;
        }

        .info-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 1rem;
            margin-top: 1.5rem;
            text-align: center;
        }

        .info-box p {
            color: white;
            font-size: 0.875rem;
            margin: 0;
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 1.75rem;
            }

            .logo-box {
                width: 80px;
                height: 80px;
            }

            .app-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        {{-- HEADER --}}
        <div class="text-center mb-4">
            <div class="logo-box">
                <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Logo {{ config('app.name') }}">
            </div>
            <h1 class="app-title fw-bold">Admin FEB UNSAP</h1>

            <p class="app-subtitle">Silakan login untuk melanjutkan</p>
        </div>

        {{-- LOGIN CARD --}}
        <div class="login-card">
            {{-- FLASH MESSAGES --}}
            @if(session('success'))
            <div class="alert alert-success alert-custom">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-3"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-custom">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-3"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
            @endif

            {{-- GOOGLE LOGIN --}}
            <a href="{{ route('auth.google') }}" class="google-btn">
                <svg width="20" height="20" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <span>Login dengan Google</span>
            </a>

            {{-- DIVIDER --}}
            <div class="divider">
                <span>atau</span>
            </div>

            {{-- TRADITIONAL LOGIN FORM --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="position-relative">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email') }}"
                               required
                               class="form-control form-control-custom @error('email') is-invalid @enderror"
                               placeholder="nama@email.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="position-relative">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               required
                               class="form-control form-control-custom @error('password') is-invalid @enderror"
                               placeholder="••••••••">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Remember Me --}}
                <div class="mb-4">
                    <div class="form-check">
                        <input type="checkbox" 
                               name="remember" 
                               id="remember"
                               class="form-check-input">
                        <label class="form-check-label" for="remember">
                            Ingat saya
                        </label>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="btn btn-login">
                    Login
                </button>
            </form>

            {{-- Footer Link --}}
            <div class="mt-4 text-center footer-link">
                <p>Belum punya akun? 
                    <a href="{{ route('home') }}">Kembali ke Beranda</a>
                </p>
            </div>
        </div>

    

        {{-- INFO BOX --}}
        <div class="info-box">
            <p>
                <i class="fas fa-info-circle me-2"></i>
                Gunakan akun Google untuk login lebih cepat
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>