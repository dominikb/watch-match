<?php

namespace App\Jobs;

use Tmdb\Model\Movie;
use Illuminate\Bus\Queueable;
use Tmdb\Repository\MovieRepository;
use App\Models\MovieMetaInformation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

# Deprecation warnings when using from tmdb api client
error_reporting(E_ERROR ^ E_DEPRECATED);

class CheckMovieForRecommendability implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private int $movieId)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var MovieRepository $movieRepository */
        $movieRepository = app(MovieRepository::class);

        /** @var Movie $movie */
        $movie = $movieRepository->load($this->movieId);

        $recommendable = $this->hasDescription($movie)
            && $this->hasImage($movie)
            && $this->hasCorrectLanguage($movie);

        MovieMetaInformation::where('movie_id', $this->movieId)
                            ->update([
                                'recommendable'                 => $recommendable,
                                'check_for_recommendability_at' => now(),
                            ])
        ;
    }

    public function hasDescription(Movie $movie)
    {
        return strlen($movie->getOverview()) > 5;
    }

    private function hasImage(Movie $movie)
    {
        return $movie->getBackdropImage() != null;
    }

    private function hasCorrectLanguage(Movie $movie)
    {
        if ($movie->getOriginalLanguage() == 'de') {
            return true;
        }

        foreach ($movie->getTranslations() as $translation) {
            if ($translation->getEnglishName() == 'German') {
                return true;
            }
        }

        return false;
    }
}
