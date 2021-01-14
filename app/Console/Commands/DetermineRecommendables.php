<?php

namespace App\Console\Commands;

# Deprecation warnings when using from tmdb api client
error_reporting(E_ERROR);

use Tmdb\Model\Tv;
use App\Models\Movie;
use App\Models\TvShow;
use App\Models\Recommendable;
use Illuminate\Console\Command;
use Tmdb\Repository\TvRepository;
use Tmdb\Repository\MovieRepository;
use App\Models\MovieMetaInformation;
use App\Models\TvShowMetaInformation;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\QueryException;

class DetermineRecommendables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:determine-recommendables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transfer all tv shows and movies from their respective meta info table to the recommendables table, if eligable.';

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
        $this->determineTvShowsAsRecommendables();
        $this->determineMoviesAsRecommendables();

        return 0;
    }

    public function determineTvShowsAsRecommendables(): void
    {
        /** @var TvRepository $tvRepository */
        $tvRepository = app(TvRepository::class);

        $cursor = TvShowMetaInformation::whereRecommendable(true)
                                       ->whereNotIn('tv_show_id', function (Builder $query) {
                                           $query->select('original_id')
                                                 ->from((new Recommendable)->getTable())
                                                 ->where('type', TvShow::class)
                                           ;
                                       })
                                       ->cursor()
        ;

        /** @var TvShowMetaInformation $item */
        foreach ($cursor as $item) {
            /** @var Tv $show */
            $show = $tvRepository->load($item->tv_show_id);

            try {
                TvShow::create([
                    'title'       => $show->getOriginalName(),
                    'runtime'     => $show->getNumberOfSeasons(),
                    'description' => $show->getOverview(),
                    'original_id' => $show->getId(),
                    'image_path'  => $show->getBackdropPath(),
                ]);

                $this->getOutput()->writeln("Recommending show '" . $show->getOriginalName() . "'");
            } catch (QueryException $exception) {
                // Null-Violation
                if ($exception->getCode() == 23502) {
                    $this->getOutput()->error($exception->getMessage());

                    TvShowMetaInformation::whereTvShowId($item->tv_show_id)
                                         ->update(['recommendable' => false]);
                } else {
                    throw $exception;
                }
            }
        }
    }

    public function determineMoviesAsRecommendables(): void
    {
        /** @var MovieRepository $movieRepository */
        $movieRepository = app(MovieRepository::class);

        $cursor = MovieMetaInformation::query()
                                      ->whereRecommendable(true)
                                      ->whereNotIn('movie_id', function (Builder $query) {
                                          $query->select('original_id')
                                                ->from((new Recommendable)->getTable())
                                                ->where('type', Movie::class)
                                          ;
                                      })
                                      ->cursor()
        ;

        /** @var MovieMetaInformation $item */
        foreach ($cursor as $item) {
            /** @var \Tmdb\Model\Movie $movie */
            $movie = $movieRepository->load($item->movie_id);

            try {
                Movie::create([
                    'title'       => $movie->getTitle(),
                    'runtime'     => $movie->getRuntime(),
                    'description' => $movie->getOverview(),
                    'original_id' => $movie->getId(),
                    'image_path'  => $movie->getBackdropPath(),
                ]);
            } catch (QueryException $exception) {
                // Null-Violation
                if ($exception->getCode() == 23502) {
                    $this->getOutput()->error($exception->getMessage());

                    MovieMetaInformation::whereMovieId($item->movie_id)
                                        ->update(['recommendable' => false])
                    ;
                } else {
                    throw $exception;
                }
            }

            $this->getOutput()->writeln("Recommending movie '" . $movie->getTitle() . "'");
        }
    }
}
