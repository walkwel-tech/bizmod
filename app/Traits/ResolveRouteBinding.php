<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait ResolveRouteBinding {

    public function resolveRouteBinding($value, $field = null)
    {
        $user = auth()->user();
        if ( !method_exists($user, 'hasRole') || $user->hasRole('super')) {
            return $this->withTrashed()->where($this->getRouteKeyName(), $value)->firstOrFail();
        } else {
            return $this->where($this->getRouteKeyName(), $value)->firstOrFail();
        }
    }
}
