<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserMovieInformation;
use Tmdb\Repository\MovieRepository;

class LikeController extends Controller
{
    public function __construct(private MovieRepository $movieRepository)
    {
    }

    public function __invoke(Request $request)
    {
        $userMovieInformation = UserMovieInformation::query()
            ->where('rating', 'like')
            ->where('username', session('username'))
            ->simplePaginate(4);

        $movies = collect($userMovieInformation->items())
            ->map(function (UserMovieInformation $item) {
                return $this->movieRepository->load($item->movie_id);
            });

        return view('likes', compact(
            'userMovieInformation', 'movies'
        ));
    }
}
