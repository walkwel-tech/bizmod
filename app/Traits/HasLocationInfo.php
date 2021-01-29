<?php
namespace App\Traits;

use App\City;
use App\Country;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

trait HasLocationInfo {
    use HasCountryInfo;
    //region methods
    public function setLocationByName ($countryName, $stateName, $cityName) {
        $country = Country::name($countryName)->first();
        $state = $country->states()->name($stateName)->first();
        if (is_null($state)) {
            $state = $country->states()->create([
                'name' => $stateName
            ]);
        }
        $city = $state->cities()->name($cityName)->first();
        if (is_null($city)) {
            $city = $state->cities()->create([
                'name' => $cityName
            ]);
        }
        $this->country_id = $country->id ?? null;
        $this->state_id = $state->id ?? null;
        $this->city_id = $city->id ?? null;

        return $this;
    }

    public function setLocation($key, Request $request)
    {
        $country_id = $request->input('country.' . $key);

        $this->country_id = $country_id ? $country_id : $this->country_id;
        $this->state_id = $request->input('state.' . $key);
        $this->city_id = $request->input('city.' . $key);
    }

    public function relatesToState(State $state)
    {
        return $this->state_id === $state->id;
    }

    public function relatesToCity(City $city)
    {
        return $this->city_id === $city->id;
    }

    public function getStateName()
    {
        return $this->state ? $this->state->name : null;
    }

    public function getCityName()
    {
        return $this->city ? $this->city->name : null;
    }

    //endregion methods

    //region relationships

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    //endregion relationships

    public function scopeForLocations($query, $locationsData)
    {
        $location = Arr::wrap($locationsData);


        if (Arr::has($location, 'country')) {
            $query->onlyForCountry($location['country']);
        }

        if (Arr::has($location, 'state')) {
            $query->onlyForState($location['state']);
        }

        if (Arr::has($location, 'city')) {
            $query->onlyForCity($location['city']);
        }
    }


    public function scopeOnlyForState ($query, $stateName) {
        return $query->onlyForRelationWithName('state', $stateName);
    }

    public function scopeOnlyForCity ($query, $cityName) {
        return $query->onlyForRelationWithName('city', $cityName);
    }

    public function scopeOnlyForRelationWithName($query, $relation, $names)
    {
        $query->whereHas($relation, function ($query) use ($names) {
            if (!is_array($names)) {
                $query->where('name', 'like', $names);
            } else {
                $query->where(function ($subQuery) use ($names) {
                    foreach ($names as $name) {
                        $subQuery->orWhere('name', 'like', $name);
                    }
                });
            }
        });
    }

}
