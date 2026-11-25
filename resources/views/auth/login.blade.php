<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - KursusKu</title>
    <!-- Gunakan Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-container {
            height: 100vh;
            display: flex;
        }
        /* Bagian Kiri: Banner Sambutan */
        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #0f766e 0%, #115e59 100%); /* Warna Hijau Gelap KursusKu */
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 5rem;
            position: relative;
            overflow: hidden;
        }
        /* Efek dekorasi lingkaran */
        .login-left::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -100px;
            left: -100px;
        }
        .login-left::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -50px;
            right: -50px;
        }
        .login-left h1 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            z-index: 1;
        }
        .login-left p {
            font-size: 1.2rem;
            opacity: 0.9;
            z-index: 1;
            max-width: 80%;
        }
        /* Bagian Kanan: Form Login */
        .login-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ffffff;
            padding: 2rem;
        }
        .login-form-box {
            width: 100%;
            max-width: 400px;
        }
        .login-form-box h2 {
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }
        .login-form-box p {
            color: #6b7280;
            margin-bottom: 2rem;
        }
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
        }
        .form-control:focus {
            border-color: #0f766e;
            box-shadow: 0 0 0 0.25rem rgba(15, 118, 110, 0.25);
        }
        .btn-login {
            background-color: #0f766e;
            color: white;
            padding: 0.75rem;
            border-radius: 0.5rem;
            font-weight: 600;
            width: 100%;
            border: none;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background-color: #115e59;
            transform: translateY(-2px);
        }
        /* Responsif untuk HP */
        @media (max-width: 768px) {
            .login-left { display: none; }
            .login-right { background-color: #f8f9fa; }
            .login-form-box { background: white; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        }
    </style>
</head>
<body>

<div class="login-container">
    <!-- Sisi Kiri: Banner -->
    <div class="login-left">
        <h1>Selamat Datang<br>Kembali! 👋</h1>
        <p>Masuk ke akun Anda untuk melanjutkan perjalanan belajar dan mengelola kursus Anda di KursusKu.</p>
    </div>

    <!-- Sisi Kanan: Form -->
    <div class="login-right">
        <div class="login-form-box">
            <h2>Masuk ke Dashboard</h2>
            <p>Silakan masukkan kredensial Anda.</p>

            <!-- Alert Error/Sukses -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Masukkan email Anda" required autofocus>
                    @error('email')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">Lihat</button>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Ingat Saya</label>
                    </div>
                    <a href="#" class="text-decoration-none" style="color: #0f766e;">Lupa Password?</a>
                </div>

                <!-- Teks Tombol Diubah -->
                <button type="submit" class="btn-login mb-3">Masuk ke Dashboard</button>
                
                <div class="text-center mt-3">
    <a href="{{ route('home') }}" class="text-muted text-decoration-none small">
        ← Kembali ke Beranda
    </a>
</div>

<div class="text-center mt-3">
    <a href="{{ route('home') }}#keunggulan" class="text-muted text-decoration-none small">
        Keunggulan
    </a>
    |
    <a href="{{ route('home') }}#kursus" class="text-muted text-decoration-none small">
        Katalog
    </a>
    |
    <a href="{{ route('home') }}#alur" class="text-muted text-decoration-none small">
        Cara Daftar
    </a>
</div>

<div class="text-center mt-2">
    <a href="{{ route('home') }}#media" class="text-muted text-decoration-none small">
        Media
    </a>
    |
    <a href="{{ route('home') }}#kontak" class="text-muted text-decoration-none small">
        Kontak
    </a>
</div>

<div class="text-center mt-2">
    <a href="{{ route('enrollments.create') }}" class="text-muted text-decoration-none small">
        Pendaftaran Kursus
    </a>
    |
    <a href="{{ route('courses.index') }}" class="text-muted text-decoration-none small">
        KursusKu
    </a>
</div>

<!-- Script Hiding Password -->
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            this.textContent = 'Sembunyikan';
        } else {
            passwordInput.type = 'password';
            this.textContent = 'Lihat';
        }
    });
</script>
</body>
</html>