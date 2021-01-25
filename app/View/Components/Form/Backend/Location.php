<?php

namespace App\View\Components\Form\Backend;

use App\Contracts\Repository\LocationsRepositoryContract;
use Illuminate\View\Component;

class Location extends Component
{
    public $countries;
    public $states;
    public $cities;

    public $prefix;
    public $model;
    public $readOnlyCountry;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        LocationsRepositoryContract $locationRepo,
        $model,
        $prefix = null,
        $readOnlyCountry = false,
        $countries = null,
        $states = null,
        $cities = null
    ) {
        $this->model = $model;
        $this->readOnlyCountry = $readOnlyCountry;
        $this->prefix = $prefix ?? 'address';

        $this->countries = $countries ?? $locationRepo->getCountries();
        $this->states = $states ?? collect();//$locationRepo->getStates();
        $this->cities = $cities ?? collect();//$locationRepo->getCities();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form.backend.location');
    }
}
