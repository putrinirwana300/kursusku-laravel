<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'KursusKu')</title>
    <!-- Memanggil CSS dari folder public/css/style.css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @include('partials.navbar')
    <main>
        @yield('content')
    </main>
</body>
</html>