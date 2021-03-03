<?php

namespace App\Scopes;

use App\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class HasAccessClientsScope implements Scope
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
        if (!($model instanceof Client)) {
            return $builder;
        }

        if($user = auth()->user()) {
            if (!method_exists($user, 'hasRole') || $user->hasRole('super')) {
                return $builder;
            }

            $businessIds = $user->businessIds->pluck('business_id')->toArray();
            $builder->with('codes', function ($codeQuery) use ($businessIds) {
                return $codeQuery->whereIn('business_id', $businessIds);
            });

            $builder->whereHas('codes', function ($codeQuery) use ($businessIds) {
                return $codeQuery->whereIn('business_id', $businessIds);
            });
        }

        return $builder;
    }
}
