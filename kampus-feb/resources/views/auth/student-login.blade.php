<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Mahasiswa - {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('assets/img/logo/logo.png') }}" type="image/x-icon">
<link rel="shortcut icon" href="{{ asset('assets/img/logo/logo.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
            --bg-body: #f1f5f9;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --card-radius: 16px; /* Radius petak yang profesional */
        }

        body {
            background-color: var(--bg-body);
            background-image: radial-gradient(#cbd5e1 0.5px, transparent 0.5px);
            background-size: 24px 24px; /* Pattern dot halus */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
        }

        .login-card {
            background: white;
            width: 100%;
            max-width: 420px;
            border-radius: var(--card-radius);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(226, 232, 240, 0.8);
            overflow: hidden;
            padding: 2.5rem;
        }

        /* Logo box di dalam atas card */
        .logo-wrapper {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .logo-box {
            width: 72px;
            height: 72px;
            background: #ffffff;
            border-radius: 14px; /* Petak dengan radius halus */
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e2e8f0;
            padding: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        .logo-box img {
            max-width: 100%;
            height: auto;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            letter-spacing: -0.025em;
        }

        .login-header p {
            color: var(--text-muted);
            font-size: 0.925rem;
        }

        /* Form Styling */
        .form-label {
            font-weight: 500;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            color: var(--text-main);
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .form-control-custom {
            height: 48px;
            padding-left: 2.75rem;
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .form-control-custom:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1rem;
            z-index: 10;
        }

        .btn-login {
            height: 48px;
            width: 100%;
            background-color: var(--primary-color);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s;
            margin-top: 0.5rem;
        }

        .btn-login:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Alert styling */
        .alert {
            font-size: 0.875rem;
            border-radius: 10px;
            border: none;
            margin-bottom: 1.5rem;
        }

        /* Info hint */
        .info-hint {
            background: #f8fafc;
            border-radius: 10px;
            padding: 1rem;
            margin-top: 1.5rem;
            border: 1px dashed #e2e8f0;
        }

        .info-hint p {
            margin-bottom: 0;
            font-size: 0.815rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .divider {
            margin: 1.5rem 0;
            display: flex;
            align-items: center;
            text-align: center;
            color: #cbd5e1;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }

        .divider:not(:empty)::before { margin-right: 1rem; }
        .divider:not(:empty)::after { margin-left: 1rem; }

        .footer-links {
            text-align: center;
            font-size: 0.875rem;
        }

        .footer-links a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 1.75rem;
            }
        }
    </style>
</head>
<body>

    <div class="login-card">
        {{-- Logo Section --}}
        <div class="logo-wrapper">
            <div class="logo-box">
                <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Logo">
            </div>
        </div>

        {{-- Header Section --}}
        <div class="login-header">
            <h1>Portal Mahasiswa</h1>
            <p>FEB UNSAP</p>
        </div>

        {{-- Flash Messages --}}
        @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        </div>
        @endif

        {{-- Form Section --}}
        <form method="POST" action="{{ route('student.login') }}">
            @csrf

            <div class="form-group">
                <label for="nim" class="form-label">NIM</label>
                <div class="input-group-custom">
                    <i class="fas fa-id-card input-icon"></i>
                    <input type="text" 
                           name="nim" 
                           id="nim" 
                           class="form-control form-control-custom" 
                           placeholder="Masukkan NIM"
                           required>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-group-custom">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" 
                           name="password" 
                           id="password" 
                           class="form-control form-control-custom" 
                           placeholder="Masukkan Password"
                           required>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label text-muted" for="remember" style="font-size: 0.85rem;">
                        Ingat saya
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-login">
                Masuk ke Portal
            </button>
        </form>

        {{-- Hint Section --}}
        <div class="info-hint">
            <p>
                <i class="fas fa-info-circle me-1 text-primary"></i> 
                <strong>Password default:</strong> Gunakan tanggal lahir Anda dengan format <code>DDMMYYYY</code> (Contoh: 29032007).
            </p>
        </div>

        <div class="divider">Akses Lainnya</div>

        {{-- Footer Links --}}
        <div class="footer-links">
            <div class="mb-2">
            </div>
            <a href="{{ route('home') }}" class="text-muted small">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>