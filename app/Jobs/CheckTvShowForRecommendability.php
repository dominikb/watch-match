<?php

namespace App\Jobs;

# Deprecation warnings when using from tmdb api client
error_reporting(E_ERROR);

use Tmdb\Model\Tv;
use Illuminate\Bus\Queueable;
use Tmdb\Repository\TvRepository;
use App\Models\TvShowMetaInformation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckTvShowForRecommendability implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private int $tvShowId)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var TvRepository $tvRepository */
        $tvRepository = app(TvRepository::class);

        /** @var Tv $movie */
        $movie = $tvRepository->load($this->tvShowId);

        $recommendable = $this->hasDescription($movie)
            && $this->hasImage($movie)
            && $this->hasCorrectLanguage($movie);

        TvShowMetaInformation::query()
             ->where('tv_show_id', $this->tvShowId)
             ->update([
                 'recommendable'                 => $recommendable,
                 'check_for_recommendability_at' => now(),
             ]);
    }

    public function hasDescription(Tv $show)
    {
        return strlen($show->getOverview()) > 5;
    }

    private function hasImage(Tv $show)
    {
        return $show->getBackdropImage() != null;
    }

    private function hasCorrectLanguage(Tv $show)
    {
        if ($show->getOriginalLanguage() == 'de') {
            return true;
        }

        foreach ($show->getTranslations() as $translation) {
            if ($translation->getEnglishName() == 'German') {
                return true;
            }
        }

        return false;
    }
}
