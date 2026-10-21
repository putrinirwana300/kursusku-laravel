<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $siteName }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- HEADER (Judul Besar di Atas) -->
    <header class="header">
        <div class="container">
            <h1>{{ $siteName }}</h1>
            <p>Belajar Teknologi, Bangun Masa Depan</p>
        </div>
    </header>

    <!-- NAVBAR (Menu Navigasi) -->
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('home') }}">Beranda</a>
            <a href="#">Keunggulan</a>
            <a href="#">Katalog</a>
            <a href="#">Cara Daftar</a>
            <a href="#">Media</a>
            <a href="#">Kontak</a>
            <a href="#">Form P5</a>
            <a href="#">Daftar P6</a>
            <a href="#">History</a>
        </div>
    </nav>

    <!-- HERO SECTION (Teks & Gambar) -->
    <main>
        <section class="hero">
            <div class="container">
                <div class="hero-content">
                    <div>
                        <h2>Selamat Datang di {{ $siteName }}</h2>
                        <p>Platform belajar teknologi untuk mahasiswa yang ingin meningkatkan kemampuan pemrograman web.</p>
                        <a href="#" class="button">Lihat Kursus</a>
                        <a href="#" class="button">Lihat Estimasi Biaya</a>
                        <a href="#" class="button">Daftar Kursus</a>
                    </div>
                    <div>
                        <img src="{{ asset('images/hero-kursus.jpg') }}" alt="Mahasiswa belajar pemrograman web" class="hero-image">
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION KURSUS (Kartu-kartu) -->
        <section id="kursus" class="section">
            <div class="container">
                <h2>Katalog Kursus</h2>
                <div class="course-grid">
                    @foreach ($featured as $course)
                    <article class="course-card">
                        <h3>{{ $course['name'] }}</h3>
                        <p>{{ $course['description'] }}</p>
                    </article>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} {{ $siteName }}. Pemrograman Web III.</p>
        </div>
    </footer>
</body>
</html>