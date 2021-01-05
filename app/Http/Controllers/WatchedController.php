<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tmdb\Repository\MovieRepository;
use App\Models\UserMovieInformation;

class WatchedController extends Controller
{
    public function __construct(private MovieRepository $movieRepository)
    {
    }

    public function __invoke(Request $request)
    {
        $userMovieInformation = UserMovieInformation::query()
                                                    ->where('rating', 'seen')
                                                    ->where('username', session('username'))
                                                    ->simplePaginate(4);
        $movies = collect($userMovieInformation->items())
            ->map(function (UserMovieInformation $item) {
                return $this->movieRepository->load($item->movie_id);
            });

        return view('watched', compact(
            'userMovieInformation', 'movies'
        ));
    }
}
