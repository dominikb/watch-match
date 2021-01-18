<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recommendable;
use Illuminate\Database\Query\Builder;
use App\Models\UserRecommendableRating;

class DislikesController extends Controller
{
    public function __invoke(Request $request)
    {
        $dislikes = Recommendable::query()
          ->whereIn('id', function(Builder $query) {
              $query->select('recommendable_id')
                    ->from((new UserRecommendableRating())->getTable())
                    ->where('rating', 'dislike')
                    ->where('username', session('username'));
          })->get();

        return view('dislikes', compact('dislikes'));
    }
}
