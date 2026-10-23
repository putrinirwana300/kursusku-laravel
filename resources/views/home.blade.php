@extends('layouts.app')

@section('title', 'Beranda - KursusKu')

@section('content')
<!-- 1. HERO -->
<section id="beranda" class="hero">
    <div class="container">
        <div class="hero-content">
            <div>
                <h2>Selamat Datang di {{ $siteName }}</h2>
                <p>Platform belajar teknologi untuk mahasiswa yang ingin meningkatkan kemampuan pemrograman web.</p>
                <a href="#kursus" class="button">Lihat Kursus</a>
                <a href="#" class="button">Lihat Estimasi Biaya</a>
                <a href="{{ route('enrollments.create') }}" class="button">Daftar Kursus</a>
            </div>
            <div>
                <img src="{{ asset('images/hero-kursus.jpg') }}" alt="Mahasiswa belajar" class="hero-image">
            </div>
        </div>
    </div>
</section>

<!-- 2. KEUNGGULAN -->
<section id="keunggulan" class="section">
    <div class="container">
        <h2>Mengapa Memilih KursusKu?</h2>
        <div class="course-grid">
            <article class="course-card">
                <h3>Materi Terarah</h3>
                <p>Materi disusun bertahap dari dasar hingga praktik.</p>
            </article>
            <article class="course-card">
                <h3>Belajar dengan Proyek</h3>
                <p>Setiap tahap menghasilkan aplikasi nyata.</p>
            </article>
            <article class="course-card">
                <h3>Pendampingan Praktik</h3>
                <p>Belajar melalui demonstrasi, latihan, dan evaluasi.</p>
            </article>
        </div>
    </div>
</section>

<!-- 3. KATALOG KURSUS (Tabel Lengkap) -->
<section id="kursus" class="section section-light">
    <div class="container">
        <h2>Katalog Kursus</h2>
        <table style="width:100%; border-collapse:collapse; margin-top:16px;">
            <thead>
                <tr style="background:#0f766e; color:white;">
                    <th style="padding:10px; border:1px solid #ddd;">Kode</th>
                    <th style="padding:10px; border:1px solid #ddd;">Nama</th>
                    <th style="padding:10px; border:1px solid #ddd;">Biaya</th>
                    <th style="padding:10px; border:1px solid #ddd;">Mulai</th>
                    <th style="padding:10px; border:1px solid #ddd;">Sisa</th>
                    <th style="padding:10px; border:1px solid #ddd;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($featured as $course)
                <tr>
                    <td style="padding:10px; border:1px solid #ddd;">{{ $course['code'] }}</td>
                    <td style="padding:10px; border:1px solid #ddd;">{{ $course['name'] }}</td>
                    <td style="padding:10px; border:1px solid #ddd;">Rp {{ number_format($course['fee'], 0, ',', '.') }}</td>
                    <td style="padding:10px; border:1px solid #ddd;">{{ date('d-m-Y', strtotime($course['start_date'])) }}</td>
                    <td style="padding:10px; border:1px solid #ddd;">{{ max(0, $course['quota'] - $course['registered']) }}</td>
                    <td style="padding:10px; border:1px solid #ddd;">
                        @if($course['registered'] >= $course['quota'])
                            <span style="background:#fdeaea; color:#a61b1b; padding:4px 8px; border-radius:99px; font-weight:bold;">Penuh</span>
                        @else
                            <span style="background:#e7f8ef; color:#146c43; padding:4px 8px; border-radius:99px; font-weight:bold;">Tersedia</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<!-- 4. CARA MENDAFTAR -->
<section id="alur" class="section">
    <div class="container">
        <h2>Cara Mendaftar</h2>
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-number">1</div>
                <h3>Pilih Kursus</h3>
                <p>Pilih kursus yang diminati.</p>
            </div>
            <div class="step-card">
                <div class="step-number">2</div>
                <h3>Isi Form</h3>
                <p>Lengkapi form pendaftaran.</p>
            </div>
            <div class="step-card">
                <div class="step-number">3</div>
                <h3>Periksa Data</h3>
                <p>Periksa kembali data Anda.</p>
            </div>
            <div class="step-card">
                <div class="step-number">4</div>
                <h3>Kirim</h3>
                <p>Tunggu konfirmasi.</p>
            </div>
        </div>
    </div>
</section>

<!-- 5. TENTANG -->
<section id="tentang" class="section section-light">
    <div class="container">
        <h2>Tentang KursusKu</h2>
        <p>KursusKu merupakan prototype website pembelajaran yang dikembangkan dalam mata kuliah Pemrograman Web III.</p>
        <p>Pada semester ini mahasiswa akan belajar PHP, MySQL dan framework Laravel.</p>
        <a href="https://laravel.com" target="_blank" rel="noopener">Pelajari Laravel</a>
    </div>
</section>

<!-- 6. MEDIA / VIDEO -->
<section id="media" class="section">
    <div class="container">
        <h2>Video Pembelajaran</h2>
        <div style="text-align: center; margin-top: 20px;">
            <iframe width="342" height="607" src="https://www.youtube.com/embed/nQinn48Bk2g" title="Kenapa Laravel Masih Banyak Yang Pake" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
    </div>
</section>

<!-- 7. KONTAK -->
<section id="kontak" class="section section-light">
    <div class="container">
        <h2>Kontak</h2>
        <p>Informasi lebih lanjut mengenai program KursusKu dapat diperoleh melalui halaman ini.</p>
    </div>
</section>
@endsection