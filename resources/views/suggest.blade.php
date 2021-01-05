@extends('layouts.app')

@section('content')
    <h1>WatchMatch</h1>

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
@endsection
