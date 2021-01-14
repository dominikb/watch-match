<?php


namespace App\Models;


use Parental\HasParent;

class Movie extends Recommendable
{
    use HasParent;

    public function getFormattedRuntime() : string
    {
        return sprintf("%d min", $this->runtime);
    }

}
