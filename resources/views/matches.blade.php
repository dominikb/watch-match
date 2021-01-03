<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Matches</title>

</head>
<body class="antialiased">

    @include('partials/menu')

    <br>

    @foreach($movies as $movie)
        <img src="{{ config('tmdb.image_path') . $movie->getPosterPath() }}" alt="Movie poster" width="400px">
    @endforeach
</body>
</html>
