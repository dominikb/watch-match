<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\WatchProviderService;
use App\Models\MovieMetaInformation;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckWatchProvidersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected int $movieId)
    {
    }

    public function handle(WatchProviderService $watchProviderService)
    {
        $meta = MovieMetaInformation::whereMovieId($this->movieId)->firstOrFail();

        $meta = $watchProviderService->updateWatchProviderAvailability($meta);

        $meta->saveOrFail();
    }
}
