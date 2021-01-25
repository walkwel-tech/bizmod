<?php

namespace App\View\Components\Form\Backend;

use App\Address;
use Illuminate\View\Component;

class AddressInput extends Component
{
    public $prefix;
    public $model;
    public $address;
    public $locationOnly;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $model = null,
        $address = null,
        $prefix = null,
        $locationOnly = false
    ) {
        $this->model = $model;
        $this->address = $address ?? new Address();
        $this->prefix = $prefix ?? $address->slug ? $address->slug : 'address';
        $this->locationOnly = $locationOnly;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form.backend.address-input');
    }
}
