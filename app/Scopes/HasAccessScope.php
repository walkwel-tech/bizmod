<?php

namespace App\Scopes;

use App\Business;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class HasAccessScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if($user = auth()->user()) {

            if (!method_exists($user, 'hasRole') || $user->hasRole('super')) {
                return $builder;
            }

            $businessIds = $user->businessIds->pluck('business_id')->toArray();
            $columnToSearchIn = ($model instanceof Business) ? 'businesses.id' : 'business_id';
            $builder->whereIn($columnToSearchIn, $businessIds);
        }

        return $builder;
    }
}
