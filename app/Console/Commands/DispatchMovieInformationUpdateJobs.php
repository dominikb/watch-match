<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MovieMetaInformation;
use App\Jobs\CheckWatchProvidersJob;
use App\Models\TvShowMetaInformation;
use App\Jobs\CheckMovieForRecommendability;
use App\Jobs\CheckTvShowForRecommendability;

class DispatchMovieInformationUpdateJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:dispatch-movie-information-jobs';

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
        $jobsCreated = 0;

        foreach (MovieMetaInformation::shouldUpdateNetflixProvider()->cursor() as $meta) {
            CheckWatchProvidersJob::dispatch($meta->movie_id)->onQueue('provider-updates');
            $jobsCreated++;
        }

        foreach (MovieMetaInformation::shouldUpdateRecommendability()->cursor() as $meta) {
            CheckMovieForRecommendability::dispatch($meta->movie_id);
            $jobsCreated++;
        }

        foreach (TvShowMetaInformation::shouldUpdateNetflixProvider()->cursor() as $meta) {
            CheckWatchProvidersJob::dispatch(
                $meta->tv_show_id, CheckWatchProvidersJob::TV_SHOW
            )->onQueue('provider-updates');
            $jobsCreated++;
        }

        foreach (TvShowMetaInformation::shouldUpdateRecommendability()->cursor() as $item) {
            CheckTvShowForRecommendability::dispatch($item->tv_show_id);
            $jobsCreated++;
        }

        $this->getOutput()->writeln("$jobsCreated jobs created.");

        return 0;
    }
}
