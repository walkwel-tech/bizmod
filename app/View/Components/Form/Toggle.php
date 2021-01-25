<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Toggle extends Component
{
    public $name;
    public $title;
    public $value;

    public $labelOn;
    public $labelOff;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $title = "", $value = false, $labelOn = null, $labelOff = null)
    {
        //
        $this->name = $name;
        $this->title = $title ?? $name;
        $this->value = boolval($value) ?? false;
        $this->labelOn = $labelOn ?? __('basic.inputs.toggle.on');
        $this->labelOff = $labelOff ?? __('basic.inputs.toggle.off');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form.toggle');
    }
}
