<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recommendable;
use Illuminate\Database\Query\Builder;
use App\Models\UserRecommendableRating;

class SuggestionsController extends Controller
{

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $suggestion = Recommendable::query()
            ->inRandomOrder()
            ->whereNotIn('id', function(Builder $q) {
                $q->select('recommendable_id')
                    ->from((new UserRecommendableRating())->getTable())
                    ->where('username', session('username'));
            })
            ->firstOrFail();

        return view('suggest', compact('suggestion'));
    }
}
