<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public $name;
    public $title;
    public $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $title = "", $value = false)
    {
        //
        $this->name = $name;
        $this->title = $title ?? $name;
        $this->value = boolval($value) ?? false;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form.checkbox');
    }
}
