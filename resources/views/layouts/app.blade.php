<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KursusKu')</title>
    
    <!-- WAJIB TAMBAHKAN INI AGAR VITE (JQUERY & BOOTSTRAP) JALAN -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- (Opsional) Tetap panggil CSS lama Anda jika masih butuh -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @include('partials.navbar')
    <main>
        @yield('content')
    </main>
</body>
</html>