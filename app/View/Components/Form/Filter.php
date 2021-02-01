<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Filter extends Component
{
    public $allowedFilters;
    public $searchedParams;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($allowedFilters, $searchedParams)
    {
        $this->allowedFilters = $allowedFilters;

        $this->searchedParams = $searchedParams;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form.backend.filter');
    }
}
