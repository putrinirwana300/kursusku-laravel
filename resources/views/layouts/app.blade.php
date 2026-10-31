<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KursusKu')</title>
    
    <!-- Memanggil CSS dan JS dari Vite (Bootstrap & jQuery) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- (Opsional) Tetap panggil CSS lama Anda jika masih butuh -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Memanggil Navbar -->
    @include('partials.navbar')

    <main class="container py-4">
        <!-- Tempat konten halaman (form, tabel, dll) akan dimasukkan -->
        @yield('content')
    </main>
</body>
</html>