<?php

use Tmdb\Model\Movie;
use Tmdb\Repository\MovieRepository;
use App\Models\MovieMetaInformation;
use App\Models\UserMovieInformation;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MatchesController;
use App\Http\Controllers\SuggestionsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (MovieRepository $movieRepository) {
    $posterPaths = MovieMetaInformation::whereAvailableOnNetflix(true)
        ->inRandomOrder()
        ->take(10)
        ->get()
        ->map(function(MovieMetaInformation $entry) use ($movieRepository) {
            /** @var Movie $movie */
            $movie = $movieRepository->load($entry->movie_id);

            return config('tmdb.image_path') . $movie->getPosterPath();
        });

    return view('movies', compact('posterPaths'));
});

Route::get('/suggest', SuggestionsController::class);

Route::post('/rate-suggestion', function() {
    $type = 'unknown';
    if(request()->has('seen'))
        $type = 'seen';
    if(request()->has('like'))
        $type = 'like';
    if (request()->has('dislike'))
        $type = 'dislike';

    (new UserMovieInformation([
        'movie_id' => request('movie_id'),
        'username' => session('username'),
        'rating' => $type,
    ]))->saveOrFail();

    return redirect('/suggest');
});

Route::get('/login', function() {
    return view('login');
});

Route::post('/login', function() {
    session()->start();
    session()->put('username', request('username'));
    return redirect('/login');
});

Route::get('/logout', function() {
    session()->flush();
    return redirect('/login');
});

Route::get('/matches', MatchesController::class);

Route::get('/likes', LikeController::class);
