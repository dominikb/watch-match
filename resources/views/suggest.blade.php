<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Movie</title>

    <style>
        body {
            font-family: 'Nunito';
        }
    </style>
</head>
<body class="antialiased">

    <h1>{{ $movie->getTitle() }}</h1>
    <div>
        <img src="{{ config('tmdb.image_path') . $movie->getBackdropPath() }}" alt="Filmplakat" style="width: 100%; max-width: 500px;">
        <p>{{ $movie->getOverview() }}</p>
        <div style="display: flex;">
            @foreach($movie->getGenres() as $genre)
                <div style="padding: 20px">{{$genre->getName()}}</div>
            @endforeach
        </div>
    </div>

    <form action="/rate-suggestion" method="post">
        @csrf
        <input hidden type="text" name="movie_id" value="{{ $movie->getId() }}">
        <button name="dislike">Dislike</button>
        <button name="seen">Seen</button>
        <button name="like">Like</button>
    </form>

    @include('partials/menu')
</body>
</html>
