<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MovieMetaInformation;
use App\Jobs\CheckWatchProvidersJob;
use App\Jobs\CheckMovieForRecommendability;

class DispatchRequiredWatchProviderUpdateJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:dispatch-watch-provider-update-jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find all MovieMetaInformation where the watch provider info is out of date and dispatch an update job for it.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $count = 0;
        foreach (MovieMetaInformation::shouldUpdateNetflixProvider()->cursor() as $meta) {
            $count++;
            CheckWatchProvidersJob::dispatch($meta->movie_id);
            CheckMovieForRecommendability::dispatch($meta->movie_id);
        }

        return 0;
    }
}
