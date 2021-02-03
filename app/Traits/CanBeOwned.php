<?php

namespace App\Traits;

use App\User;
use Str;

trait CanBeOwned {

    public static function bootCanBeOwned()
    {

    }

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function getOwnerTitle($limitCharacters = null, $end = '...')
    {
        $title = $this->owner->first_name;

        return ($limitCharacters)
                ? Str::limit($title, $limitCharacters, $end)
                : $title;
    }

    public static function getOwnerAttributeColumnName()
    {
        return 'owner_id';
    }

}
