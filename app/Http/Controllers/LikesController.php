<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recommendable;
use Illuminate\Database\Query\Builder;
use App\Models\UserRecommendableRating;

class LikesController extends Controller
{
    public function __invoke(Request $request)
    {
        $likes = Recommendable::query()
            ->whereIn('id', function(Builder $query) {
                $query->select('recommendable_id')
                      ->from((new UserRecommendableRating())->getTable())
                      ->where('rating', 'like')
                      ->where('username', session('username'));
            })->get();

        return view('likes', compact('likes'));
    }
}
