<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KursusKu')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- HEADER (JUDUL BESAR) -->
    <header class="header">
        <div class="container" style="text-align: center;">
            <h1 style="margin: 0; color: white; font-weight: bold; font-size: 32px;">KursusKu</h1>
            <p style="margin: 5px 0 0 0; color: #d1d5db; font-size: 14px;">Belajar Teknologi, Bangun Masa Depan</p>
        </div>
    </header>

    <!-- NAVBAR -->
    <nav class="navbar">
        <!-- Link Lama -->
        <a href="{{ route('home') }}" class="nav-link">Beranda</a>
        <a href="#keunggulan" class="nav-link">Keunggulan</a>
        <a href="#kursus" class="nav-link">Katalog</a>
        <a href="#alur" class="nav-link">Cara Daftar</a>
        <a href="#media" class="nav-link">Media</a>
        <a href="#kontak" class="nav-link">Kontak</a>
        <a href="{{ route('enrollments.create') }}" class="nav-link">Pendaftaran Kursus</a>

        <!-- LINK BARU: Dipindah ke paling kanan -->
        <a href="{{ route('courses.index') }}" class="nav-link">KursusKu</a>
    </nav>

    <!-- KONTEN UTAMA -->
    <main class="container py-4">
        @yield('content')
    </main>

</body>
</html>