@extends('layouts.app')

@section('content')
    <h1>Likes (Diese Seite braucht keiner</h1>

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
@endsection

