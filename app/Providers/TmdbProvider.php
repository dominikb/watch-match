<?php

namespace App\Providers;

use Tmdb\Client;
use Tmdb\ApiToken;
use Tmdb\Repository\TvRepository;
use Tmdb\Repository\MovieRepository;
use Illuminate\Support\ServiceProvider;
use Tmdb\HttpClient\Plugin\LanguageFilterPlugin;

class TmdbProvider extends ServiceProvider
{

    private Client $client;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerClient();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    protected function registerClient(): void
    {
        $this->app->singleton(Client::class, function () {
            $token = new ApiToken(config('tmdb.api_token'));

            $options = array_merge(config('tmdb.client_options'), [
            ]);

            $languageFilter = new LanguageFilterPlugin('de');

            $this->client = new Client($token, $options);
            $this->client->getHttpClient()->addSubscriber($languageFilter);

            return $this->client;
        });
    }

    protected function registerRepositories(): void
    {
        $this->app->singleton(MovieRepository::class, function() {
            return new MovieRepository($this->client);
        });

//        $this->app->singleton(TvRepository::class, function() {
//            return new TvRepository($this->client);
//        });
    }
}
