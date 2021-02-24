<?php

namespace App\Traits;
use App\Scopes\HasAccessClientsScope;

trait HasAccessClients
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
    public static function bootHasAccessClients()
    {
        static::addGlobalScope(new HasAccessClientsScope);
    }


}
