<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Slider extends Component
{
    public $name;
    public $min;
    public $max;
    public $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name = 'input-slider', $min = 100, $max = 500, $value = null)
    {
        //
        $this->name = $name;
        $this->min = $min;
        $this->max = $max;
        $this->value = $value ?? $min;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form.slider');
    }
}
