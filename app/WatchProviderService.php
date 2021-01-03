<?php

namespace App;

use GuzzleHttp\HandlerStack;
use App\Models\MovieMetaInformation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Illuminate\Http\Client\PendingRequest;
use Kevinrob\GuzzleCache\Storage\LaravelCacheStorage;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;

class WatchProviderService
{
    private PendingRequest $client;

    public function __construct() {
        $stack = HandlerStack::create();
        $stack->push(new CacheMiddleware(
            new PrivateCacheStrategy(
                new LaravelCacheStorage(Cache::store('file'))
            )
        ), 'cache');

        $this->client = Http::withOptions(['handler' => $stack])->asJson();

    }

    public function updateWatchProviderAvailability(MovieMetaInformation $meta): MovieMetaInformation
    {
        $token = config('tmdb.api_token');
        $movieId = $meta->movie_id;

        $url = config('tmdb.base_url') . "/movie/${movieId}/watch/providers?api_key=${token}";

        $providers = $this->client->get($url)->json('results.AT.flatrate');

        $meta->providers_checked_at = now();

        if (! $providers) {
            $meta->available_on_netflix = false;
        } else {
            foreach ($providers as $provider) {
                if ($provider['provider_name'] == "Netflix") {
                    $meta->available_on_netflix = true;
                    break;
                }
            }
        }

        return $meta;
    }

}
