<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recommendable;
use Tmdb\Repository\MovieRepository;
use App\Models\UserMovieInformation;
use Illuminate\Database\Query\Builder;
use App\Models\UserRecommendableRating;

class WatchedController extends Controller
{

    public function __invoke(Request $request)
    {
        // TODO: ordering
        $watched = Recommendable::query()
            ->whereIn('id', function (Builder $query) {
                $query->select('recommendable_id')
                    ->from((new UserRecommendableRating)->getTable())
                    ->where('rating', 'seen')
                    ->where('username', session('username'));
            })
            ->get();

        return view('watched', compact('watched'));
    }
}
