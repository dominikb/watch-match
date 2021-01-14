<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendable extends Model
{
    use HasFactory;
    use \Parental\HasChildren;

    protected $guarded = [];

    public function getFormattedRuntime() : string
    {
        return $this->runtime;
    }

    public function getFullImagePath() : string
    {
        return config('tmdb.image_path') . $this->image_path;
    }
}
