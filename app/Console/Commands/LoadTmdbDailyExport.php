<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Helper\ProgressBar;

class LoadTmdbDailyExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:load-tmdb-daily-export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load daily exported files containing all ids from TMDB.';

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
        if (! File::isDirectory(storage_path('tmdb_files'))) {
            File::makeDirectory(storage_path('tmdb_files'));
        }

        $this->getOutput()->text(exec("bash ./tmdb_get_daily_exports.sh"));
        $this->getOutput()->text(exec("bash ./tmdb_load_exports_to_db.sh"));

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

        $success += DB::statement(DB::raw(<<<QUERY
            insert into tv_show_meta_information (tv_show_id, original_name, popularity, created_at, updated_at)
            select id, original_name, popularity, current_timestamp, current_timestamp
            from tv_series_ids t
            where t.id in (select id from tv_series_ids except select tv_show_id from tv_show_meta_information);
        QUERY));

        return $success > 0 ? 1 : 0; // Fail on any error
    }

}
