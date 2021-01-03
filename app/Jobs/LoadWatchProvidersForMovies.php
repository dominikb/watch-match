<?php

namespace App\Jobs;

use Tmdb\Client;
use Carbon\Traits\Date;
use Illuminate\Support\Str;
use App\Models\MetaMovieId;
use GuzzleHttp\HandlerStack;
use Illuminate\Bus\Queueable;
use App\Models\WatchProviderEntry;
use Illuminate\Support\Facades\Http;
use App\Models\MovieMetaInformation;
use Illuminate\Support\Facades\Cache;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kevinrob\GuzzleCache\Storage\LaravelCacheStorage;
use Kevinrob\GuzzleCache\Strategy\GreedyCacheStrategy;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;

class LoadWatchProvidersForMovies implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $stack = HandlerStack::create();
        $stack->push(new CacheMiddleware(
            new PrivateCacheStrategy(
                new LaravelCacheStorage(Cache::store('file'))
            )
        ), 'cache');

        $client = Http::withOptions(['handler' => $stack])->asJson();

        $token = config('tmdb.api_token');

        dump("Left: " . MovieMetaInformation::shouldUpdateNetflixProvider()->count());

        $count = 0;
        /** @var MovieMetaInformation $movieMeta */
        foreach (MovieMetaInformation::shouldUpdateNetflixProvider()->cursor() as $movieMeta) {
            $movieId = $movieMeta->movie_id;
            dump($count++ . " (${movieId})");

            $url = config('tmdb.base_url') . "/movie/${movieId}/watch/providers?api_key=${token}";

            $providers = $client->get($url)->json('results.AT.flatrate');

            if (! $providers) {
                $movieMeta->update([
                    'available_on_netflix' => false,
                    'providers_checked_at' => now()
                ]);
            } else {
                $netflix = false;
                foreach ($providers as $provider) {
                    if ($provider['provider_name'] == "Netflix")
                        $netflix = true;
                }

                $movieMeta->update([
                    'available_on_netflix' => $netflix,
                    'providers_checked_at' => now()
                ]);
            }
        }
    }
}
