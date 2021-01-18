@extends('layouts.app')

@section('content')
    <h1>Dislikes</h1>

    <div class="movie_grid">
        @foreach($dislikes as $dislike)
            <div class="movie"
                 id="{{ $dislike->id }}"
                 onclick="openPopup({{ $dislike->id }}, '{{ $dislike->getFullImagePath() }}')">
                <div class="movie_image_wrapper">
                    <div class="movie_image" style="background-image: url({{ $dislike->getFullImagePath() }})"></div>
                </div>
                <strong>{{ $dislike->title }}</strong>
            </div>
        @endforeach
    </div>

@endsection
