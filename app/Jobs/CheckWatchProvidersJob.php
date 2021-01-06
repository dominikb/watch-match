<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\WatchProviderService;
use App\Models\MovieMetaInformation;
use App\Models\TvShowMetaInformation;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckWatchProvidersJob implements ShouldQueue
{
    const MOVIE = 'movie';
    const TV_SHOW = 'tv_show';

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected int $targetId,
        protected string $type = self::MOVIE)
    {
    }

    public function handle(WatchProviderService $watchProviderService)
    {
        if ($this->type == self::MOVIE) {
            $meta = MovieMetaInformation::whereMovieId($this->targetId)->firstOrFail();

            $meta = $watchProviderService->updateWatchProviderAvailability($meta);

            $meta->saveOrFail();
        }
        if ($this->type == self::TV_SHOW) {
            $meta = TvShowMetaInformation::whereTvShowId($this->targetId)
                ->firstOrFail();

            $watchProviderService
                ->updateTvShowWatchProviderAvailability($meta)
                ->saveOrFail();
        }
    }
}
