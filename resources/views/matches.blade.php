@extends('layouts.app')

@section('content')
    <h1>Matches</h1>

    <div class="movie_grid">
        @foreach($movies as $movie)
            <div class="movie">
                <div class="movie_image_wrapper">
                    <div class="movie_image" style="background-image: url({{ config('tmdb.image_path') . $movie->getBackdropPath() }})"></div>
                </div>
                <strong>{{ $movie->getTitle() }}</strong>
            </div>
        @endforeach
    </div>
@endsection
