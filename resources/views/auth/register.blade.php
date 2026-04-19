<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Daftar - Pengaduan Siswa</title>
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.4/dist/tailwind.min.css">
        @endif
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            * {
                font-family: 'Poppins', sans-serif;
            }
            
            body {
                display: flex;
                align-items: center;
                justify-content: center;
                background: linear-gradient(135deg, #0d7377 0%, #14919b 25%, #00d4ff 50%, #14919b 75%, #0d7377 100%);
                background-size: 400% 400%;
                animation: gradientShift 15s ease infinite;
                min-height: 100vh;
            }
            
            @keyframes gradientShift {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
            
            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            
            .login-container {
                animation: slideUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
            }
            
            .login-card {
                background: rgba(255, 255, 255, 0.96);
                border: 1px solid rgba(13, 115, 119, 0.2);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 
                            inset 0 1px 0 0 rgba(255, 255, 255, 0.6);
                backdrop-filter: blur(20px);
                border-radius: 24px;
                overflow: hidden;
                overflow-x: hidden;
                max-width: 420px;
            }
            
            .form-group {
                margin-bottom: 24px;
                animation: fadeIn 0.6s ease-out forwards;
                opacity: 0;
                max-width: 100%;
                overflow: hidden;
            }
            
            .form-group:nth-child(1) { animation-delay: 0.2s; }
            .form-group:nth-child(2) { animation-delay: 0.3s; }
            .form-group:nth-child(3) { animation-delay: 0.4s; }
            .form-group:nth-child(4) { animation-delay: 0.5s; }
            .form-group:nth-child(5) { animation-delay: 0.6s; }
            .form-group:nth-child(6) { animation-delay: 0.7s; }
            
            .form-label {
                display: block;
                font-size: 0.95rem;
                font-weight: 600;
                color: #0d7377;
                margin-bottom: 10px;
                padding-right: 8px;
                letter-spacing: 0.3px;
                text-transform: capitalize;
                overflow-wrap: break-word;
                word-break: break-word;
                word-wrap: break-word;
                box-sizing: border-box;
                max-width: 100%;
            }
            
            .form-input {
                width: 100%;
                max-width: 100%;
                padding: 14px 18px;
                font-size: 1rem;
                border: 2px solid #d1eff5;
                border-radius: 14px;
                background: linear-gradient(135deg, #f0fffe 0%, #e0f7ff 100%);
                color: #0d7377;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                font-weight: 500;
                letter-spacing: 0.2px;
                box-sizing: border-box;
            }
            
            .form-input::placeholder {
                color: #7eb3c1;
                font-weight: 400;
            }
            
            .form-input:focus {
                outline: none;
                border-color: #00a8cc;
                background: linear-gradient(135deg, #ffffff 0%, #f0fffe 100%);
                box-shadow: 0 0 0 4px rgba(0, 168, 204, 0.15), 
                            0 8px 16px rgba(13, 115, 119, 0.12);
                transform: translateY(-2px);
            }
            
            .form-input:hover:not(:focus) {
                border-color: #00d4ff;
                background: linear-gradient(135deg, #f5ffff 0%, #e8f9fb 100%);
            }
            
            .form-select {
                width: 100%;
                max-width: 100%;
                padding: 14px 18px;
                font-size: 1rem;
                border: 2px solid #d1eff5;
                border-radius: 14px;
                background: linear-gradient(135deg, #f0fffe 0%, #e0f7ff 100%);
                color: #0d7377;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                font-weight: 500;
                letter-spacing: 0.2px;
                box-sizing: border-box;
            }
            
            .form-select:focus {
                outline: none;
                border-color: #00a8cc;
                background: linear-gradient(135deg, #ffffff 0%, #f0fffe 100%);
                box-shadow: 0 0 0 4px rgba(0, 168, 204, 0.15), 
                            0 8px 16px rgba(13, 115, 119, 0.12);
                transform: translateY(-2px);
            }
            
            .btn-login {
                width: 100%;
                max-width: 100%;
                padding: 14px 24px;
                font-size: 1.05rem;
                font-weight: 700;
                color: white;
                background: linear-gradient(135deg, #00a8cc 0%, #00d4ff 100%);
                border: none;
                border-radius: 14px;
                cursor: pointer;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 0 10px 25px rgba(0, 168, 204, 0.3);
                letter-spacing: 0.5px;
                text-transform: uppercase;
                position: relative;
                overflow: hidden;
                box-sizing: border-box;
            }
            
            .btn-login::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
                transition: left 0.5s;
            }
            
            .btn-login:hover {
                transform: translateY(-3px);
                box-shadow: 0 20px 40px rgba(0, 168, 204, 0.4);
                background: linear-gradient(135deg, #0088aa 0%, #00a8cc 100%);
            }
            
            .btn-login:hover::before {
                left: 100%;
            }
            
            .btn-login:active {
                transform: translateY(-1px);
            }
            
            .error-box {
                background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
                border: 2px solid #f87171;
                border-radius: 14px;
                padding: 14px 18px;
                margin-bottom: 20px;
                animation: slideUp 0.4s ease-out;
                box-sizing: border-box;
                max-width: 100%;
                overflow: hidden;
            }
            
            .error-box ul {
                list-style: none;
                padding: 0;
                margin: 0;
            }
            
            .error-box li {
                color: #991b1b;
                font-size: 0.95rem;
                font-weight: 500;
                display: flex;
                align-items: center;
                gap: 8px;
                line-height: 1.5;
                overflow-wrap: break-word;
                word-break: break-word;
                max-width: 100%;
                box-sizing: border-box;
            }
            
            .error-box li::before {
                content: '✕';
                font-weight: 700;
                font-size: 1.1rem;
                flex-shrink: 0;
            }
            
            .login-header {
                margin-bottom: 32px;
                animation: slideUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
                box-sizing: border-box;
                max-width: 100%;
                overflow: hidden;
            }
            
            .login-badge {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                background: linear-gradient(135deg, rgba(0, 168, 204, 0.1) 0%, rgba(0, 212, 255, 0.1) 100%);
                border: 1px solid rgba(0, 168, 204, 0.3);
                padding: 8px 16px;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 700;
                color: #0d7377;
                letter-spacing: 0.5px;
                text-transform: uppercase;
                margin-bottom: 16px;
                box-sizing: border-box;
                max-width: 100%;
                overflow: hidden;
                overflow-wrap: break-word;
                word-break: break-word;
            }
            
            .login-badge i {
                font-size: 0.9rem;
            }
            
            .login-title {
                font-size: 2rem;
                font-weight: 800;
                background: linear-gradient(135deg, #0d7377 0%, #00a8cc 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                margin-bottom: 12px;
                line-height: 1.2;
                letter-spacing: -0.5px;
                box-sizing: border-box;
                max-width: 100%;
                overflow-wrap: break-word;
                word-break: break-word;
            }
            
            .login-subtitle {
                color: #4b7c87;
                font-size: 1rem;
                line-height: 1.6;
                font-weight: 400;
                box-sizing: border-box;
                max-width: 100%;
                overflow-wrap: break-word;
                word-break: break-word;
            }
            
            .info-text {
                text-align: center;
                color: #7eb3c1;
                font-size: 0.95rem;
                margin-top: 24px;
                font-weight: 500;
                box-sizing: border-box;
                overflow-wrap: break-word;
                word-break: break-word;
                max-width: 100%;
            }
            
            .divider {
                height: 2px;
                background: linear-gradient(90deg, transparent, rgba(0, 168, 204, 0.2), transparent);
                margin: 32px 0;
            }
        </style>
    </head>
    <body class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="login-container" style="width: 100%; max-width: 480px;">
            <div class="login-card" style="padding: 32px;">
                <!-- Form Section -->
                <div>
                    <div class="login-header">
                        <div class="login-badge">
                            <i class="fas fa-user-plus"></i>
                            Pendaftaran
                        </div>
                        <h1 class="login-title">Daftar Akun</h1>
                        <p class="login-subtitle">Buat akun baru untuk mengakses sistem pengaduan.</p>
                    </div>

                    @if ($errors->any())
                        <div class="error-box">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.submit') }}">
                        @csrf

                        <div class="form-group">
                            <label for="username" class="form-label">
                                <i class="fas fa-user"></i> Username
                            </label>
                            <input
                                id="username"
                                name="username"
                                type="text"
                                value="{{ old('username') }}"
                                placeholder="Masukkan username Anda"
                                required
                                autofocus
                                class="form-input"
                            />
                        </div>

                        <div class="form-group">
                            <label for="nama" class="form-label">
                                <i class="fas fa-id-card"></i> Nama Lengkap
                            </label>
                            <input
                                id="nama"
                                name="nama"
                                type="text"
                                value="{{ old('nama') }}"
                                placeholder="Masukkan nama lengkap Anda"
                                required
                                class="form-input"
                            />
                        </div>

                        <div class="form-group">
                            <label for="role" class="form-label">
                                <i class="fas fa-users-cog"></i> Role
                            </label>
                            <select
                                id="role"
                                name="role"
                                required
                                class="form-select"
                            >
                                <option value="">Pilih role Anda</option>
                                <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock"></i> Password
                            </label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                placeholder="Masukkan password Anda"
                                required
                                class="form-input"
                            />
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-lock"></i> Konfirmasi Password
                            </label>
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                placeholder="Konfirmasi password Anda"
                                required
                                class="form-input"
                            />
                        </div>

                        <button type="submit" class="btn-login form-group">
                            <i class="fas fa-user-plus" style="margin-right: 8px;"></i>
                            Daftar Sekarang
                        </button>
                    </form>

                    <p class="info-text">
                        <i class="fas fa-info-circle"></i> Sudah punya akun? <a href="{{ route('login') }}" style="color: #00a8cc; font-weight: 600;">Masuk di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>