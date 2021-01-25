<?php
namespace App\Traits;

trait ScopesSlug {
    public function scopeSlug($query, $slug)
    {
        $slug = collect($slug)->filter()->toArray();

        return $query->whereIn('slug', $slug);
    }
}
