<?php

namespace App\Console\Commands;

use App\WatchProviderService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\MovieMetaInformation;

class UpdateMovieMetaInformationIds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update_movie_meta_ids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add/remove movie ids in meta table. Uses temporary import table movie_ids.';

    public function __construct(private WatchProviderService $watchProviderService)
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
        $success = DB::statement(DB::raw(<<<QUERY
            insert into movie_meta_information (movie_id, original_title, adult, video, popularity, created_at, updated_at)
            select id, original_title, adult, video, popularity, current_timestamp, current_timestamp
            from movie_ids mi
            where mi.id in (select id
                from movie_ids
                    except
                select movie_id
                from movie_meta_information)
        QUERY));

        $count = 0;
        foreach (MovieMetaInformation::shouldUpdateNetflixProvider()->cursor()->skip(30000) as $meta) {
            $this->watchProviderService->updateWatchProviderAvailability($meta)->saveOrFail();
            echo "$count" . PHP_EOL;
            $count++;
        }

        return $success ? 0 : 1;
    }
}
