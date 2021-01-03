<?php

namespace App\Http\Controllers;

use Tmdb\Model\Movie;
use Illuminate\Http\Request;
use App\Models\MovieMetaInformation;
use Tmdb\Repository\MovieRepository;
use App\Models\UserMovieInformation;
use Illuminate\Database\Query\Builder;

class SuggestionsController extends Controller
{
    public function __construct(private MovieRepository $movieRepository)
    {
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $meta = MovieMetaInformation::query()
            ->inRandomOrder()
            ->where('available_on_netflix', true)
            // TODO: add once recommendability was checked a bit more
//            ->where('recommendable', true)
            ->whereNotIn('movie_id', function(Builder $query) {
                return $query->select('movie_id')
                    ->from(with(new UserMovieInformation())->getTable())
                    ->where('username', session('username'));
            })
            ->first();

        $movie = $this->movieRepository->load($meta->movie_id);

        return view('suggest', compact('movie'));
    }
}
