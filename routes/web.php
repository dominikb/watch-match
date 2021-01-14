<?php

use Illuminate\Support\Facades\Route;
use App\Models\UserRecommendableRating;
use App\Http\Controllers\MatchesController;
use App\Http\Controllers\WatchedController;
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

Route::redirect('/', '/login');

Route::get('/suggest', SuggestionsController::class);

Route::post('/rate-suggestion', function() {
    $type = 'unknown';
    if(request()->has('seen'))
        $type = 'seen';
    if(request()->has('like'))
        $type = 'like';
    if (request()->has('dislike'))
        $type = 'dislike';

    UserRecommendableRating::create([
        'recommendable_id' => request('recommendable_id'),
        'username' => session('username'),
        'rating' => $type,
    ]);

    return redirect('/suggest');
});

Route::post('/undo-like', function() {
    UserRecommendableRating::query()
        ->where('username', session('username'))
        ->where('recommendable_id', request('recommendable_id'))
        ->delete();

    return redirect('/matches');
});

Route::get('/login', function() {
    return view('login');
});

Route::post('/login', function() {
    session()->start();
    session()->put('username', request('username'));
    return redirect('/suggest');
});

Route::get('/logout', function() {
    session()->flush();
    return redirect('/login');
});

Route::get('/matches', MatchesController::class);
Route::get('/watched', WatchedController::class);
