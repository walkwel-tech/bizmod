<?php

namespace App\Traits;
use App\Scopes\HasAccessScope;

trait HasAccess
{
    /**
     * Indicates if the model is currently force deleting.
     *
     * @var bool
     */

    /**
     * Boot the soft deleting trait for a model.
     *
     * @return void
     */
    public static function bootHasAccess()
    {
        static::addGlobalScope(new HasAccessScope);
    }


}
