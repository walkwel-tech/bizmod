<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait PerformsBasicSEO {
    public function getSEOTitle($limitCharacters = null, $end = '...')
    {
        $title = $this->getAttribute(static::getTitleAttributeColumnName());

        return ($limitCharacters)
                ? Str::limit($title, $limitCharacters, $end)
                : $title;
    }

    public static function getTitleAttributeColumnName()
    {
        return 'title';
    }

}
