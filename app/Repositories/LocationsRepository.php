<?php

namespace App\Repositories;

use App\City;
use App\Contracts\Repository\LocationsRepositoryContract;
use App\Country;
use App\State;
use Illuminate\Database\Eloquent\Collection;

class LocationsRepository implements LocationsRepositoryContract
{
    public function getCountries(): Collection
    {
        $countries = Country::all();

        return $countries;
    }

    public function getStates(): Collection
    {
        $states = State::all();

        return $states;
    }

    public function getCities(): Collection
    {
        $cities = City::all();

        return $cities;
    }

    public function getStatesForCountry($countryId): Collection
    {
        $country = Country::with('states')->findOrFail($countryId);
        $states  = $country->states;

        return $states;
    }

    public function getCitiesForState($stateId): Collection
    {
        $state = State::with('cities')->findOrFail($stateId);
        $cities = $state->cities;

        return $cities;
    }
}
