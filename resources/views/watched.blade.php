@extends('layouts.app')

@section('content')
    <h1>Watched</h1>

    <div class="movie_grid">
        @foreach($watched as $item)
            <div class="movie">
                <div class="movie_image_wrapper">
                    <div class="movie_image" style="background-image: url({{ config('tmdb.image_path') . $item->image_path }})"></div>
                </div>
                <strong>{{ $item->title }}</strong>
            </div>
        @endforeach
    </div>

@endsection

