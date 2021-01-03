<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserMovieInformation;
use Tmdb\Repository\MovieRepository;
use Illuminate\Database\Query\Builder;

class MatchesController extends Controller
{
    public function __construct(private MovieRepository $movieRepository)
    {
    }

    public function __invoke(Request $request)
    {
        $matchedWithOthers = UserMovieInformation::query()
            ->whereNotIn('username', [session('username')])
            ->where('rating', 'like')
            ->whereIn('movie_id', function(Builder $query) {
                $query->select('movie_id')
                    ->from(with(new UserMovieInformation())->getTable())
                    ->where('username', session('username'))
                ->where('rating', 'like');
            })
            ->get();

        $movies = $matchedWithOthers->map(function (UserMovieInformation $info) {
            return $this->movieRepository->load($info->movie_id);
        });

        return view('matches', compact('movies'));
    }
}
