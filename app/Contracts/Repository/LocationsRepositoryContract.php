<?php

namespace App\Contracts\Repository;

use Illuminate\Support\Collection;


interface LocationsRepositoryContract {
    public function getCountries() : Collection;
    public function getStates() : Collection;
    public function getCities() : Collection;
    public function getStatesForCountry ($countryId) : Collection;
    public function getCitiesForState($stateId) : Collection;
}
