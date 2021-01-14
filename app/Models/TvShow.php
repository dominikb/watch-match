<?php


namespace App\Models;


use Parental\HasParent;

class TvShow extends Recommendable
{
    use HasParent;

    public function getFormattedRuntime() : string
    {
        if ($this->runtime > 1)
            return sprintf("%d Staffeln", $this->runtime);
        else
            return sprintf("%d Staffel", $this->runtime);
    }
}
