<?php
namespace App\Traits;

use App\Country;

trait HasCountryInfo {
    public function getCountryIdAttribute($value)
    {
        return $value ?? 101;
    }

    public function relatesToCountry(Country $country)
    {
        return $this->country_id === $country->id;
    }

    public function getCountryName()
    {
        return $this->country ? $this->country->name : null;
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function scopeOnlyForCountry ($query, $countryName) {
        return $query->onlyForRelationWithName('country', $countryName);
    }
}
