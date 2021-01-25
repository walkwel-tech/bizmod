<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class RangeSlider extends Component
{
    public $name;
    public $min;
    public $max;
    public $valueMin;
    public $valueMax;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name = 'input-range', $min = 100, $max = 500, $valueMin = null, $valueMax = null)
    {
        //
        $this->name = $name;
        $this->min = $min;
        $this->max = $max;
        $this->valueMin = $valueMin ?? $min;
        $this->valueMax = $valueMax ?? $max;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form.range-slider');
    }
}
