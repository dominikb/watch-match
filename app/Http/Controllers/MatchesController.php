<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recommendable;
use Illuminate\Database\Query\Builder;
use App\Models\UserRecommendableRating;

class MatchesController extends Controller
{
    public function __invoke(Request $request)
    {
        $matches = Recommendable::query()
            ->whereIn('id', function(Builder $query) {
                $query->select('recommendable_id')
                    ->from((new UserRecommendableRating())->getTable())
                    ->where('rating', 'like')
                    ->whereNotIn('username', [session('username')])
                    ->whereIn('recommendable_id', function(Builder $query) {
                        $query->select('recommendable_id')
                              ->from(with(new UserRecommendableRating())->getTable())
                              ->where('username', session('username'))
                              ->where('rating', 'like');
                    });
            })->get();

        return view('matches', compact('matches'));
    }
}
