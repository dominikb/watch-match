@extends('layouts.app')

@section('content')
    <h1 class="hideme">WatchMatch</h1>

    <div class="logo"><x-icon-logo_light/></div>

    <div class="movie_card">
        <div class="movie_image_wrapper">
            <div class="movie_image" style="background-image: url({{ config('tmdb.image_path') . $movie->getBackdropPath() }})"></div>
        </div>
        <div class="movie_info">
            <strong class="title">{{ $movie->getTitle() }}</strong>
            <small class="runtime">{{$movie->getRuntime() }} min</small>
            <span class="description">
                {{ $movie->getOverview() }}
            </span>
        </div>
    </div>

    <form action="/rate-suggestion" method="post">
        @csrf
        <input hidden type="text" name="movie_id" value="{{ $movie->getId() }}">
        <div class="options_wrapper">
            <button title="Mag ich nicht" class="option_primary" name="dislike" onclick="animateOption(this)"><x-icon-close/></button>
            <button title="Hab ich schon gesehen" class="option_secondary" name="seen" onclick="animateOption(this)"><x-icon-check/></button>
            <button title="Will ich sehen" class="option_primary" name="like" onclick="animateOption(this)"><x-icon-heart/></button>
        </div>
    </form>
@endsection