<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $siteName }}</title>
</head>
<body>
    <h1>{{ $siteName }}</h1>
    
    @foreach ($featured as $course)
    <article>
        <strong>{{ $course['code'] }}</strong>
        <h2>{{ $course['name'] }}</h2>
        <p>{{ $course['description'] }}</p>
    </article>
    @endforeach
</body>
</html>