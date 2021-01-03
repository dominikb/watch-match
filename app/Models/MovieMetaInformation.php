<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieMetaInformation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeShouldUpdateNetflixProvider(Builder $query): Builder {
        return $query
            ->whereNull('providers_checked_at')
            ->orWhereDate('providers_checked_at', '<', Carbon::now()->subDays(7));
    }
}
