@extends('layouts.app')

@section('content')
    <h1>Matches</h1>

    <div class="movie_grid">
        @foreach($matches as $match)
            <div class="movie"
                 id="{{ $match->id }}"
                 onclick="openPopup({{ $match->id }}, '{{ $match->getFullImagePath() }}')">
                <div class="movie_image_wrapper">
                    <div class="movie_image" style="background-image: url({{ $match->getFullImagePath() }})"></div>
                </div>
                <strong>{{ $match->title }}</strong>
            </div>
        @endforeach
    </div>

    @include('partials.recommendable-popup')
@endsection
