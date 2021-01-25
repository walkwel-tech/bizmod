<?php

namespace App\Traits;

use Spatie\Sluggable\SlugOptions;

trait WalkwelSlugMaker {

    public function getSlugSeed()
    {
        return $this->title;
    }

    public function makeBetterSlug()
    {
        $slugSourceString = make_non_unique_slug($this->getSlugSeed());

        return $slugSourceString;
    }

        /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom([$this, 'makeBetterSlug'])
            ->saveSlugsTo($this->getSlugColumnName())
            ->slugsShouldBeNoLongerThan($this->slugLength())
            // ->doNotGenerateSlugsOnUpdate()
            ->usingSeparator('-');
    }

    protected function getSlugColumnName()
    {
        return 'slug';
    }

    public function slugLength ()
    {
        return 80;
    }
}
