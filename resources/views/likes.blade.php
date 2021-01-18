@extends('layouts.app')

@section('content')
    <h1>Likes</h1>

    <div class="movie_grid">
        @foreach($likes as $like)
            <div class="movie"
                 id="{{ $like->id }}"
                 onclick="openPopup({{ $like->id }}, '{{ $like->getFullImagePath() }}')">
                <div class="movie_image_wrapper">
                    <div class="movie_image" style="background-image: url({{ $like->getFullImagePath() }})"></div>
                </div>
                <strong>{{ $like->title }}</strong>
            </div>
        @endforeach
    </div>

@endsection
