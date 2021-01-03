<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Likes</title>

</head>
<body class="antialiased">

    @include('partials/menu')

    <div style="display: grid; grid-template-columns: 50% 50%;">
        @foreach($movies as $movie)
            <div>
                <h2>{{ $movie->getTitle() }}</h2>
                <img src="{{ config('tmdb.image_path') . $movie->getBackdropPath() }}"
                     alt="{{ $movie->getTitle() }} backdrop image"
                     style="width: 100%; max-width: 500px;">
            </div>
        @endforeach
    </div>

    {{ $userMovieInformation->links() }}


</body>
</html>
