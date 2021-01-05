@extends('layouts.app')

@section('content')
    <h1>Matches</h1>

    @foreach($movies as $movie)
        <img src="{{ config('tmdb.image_path') . $movie->getPosterPath() }}" alt="Movie poster" width="400px">
    @endforeach
@endsection
