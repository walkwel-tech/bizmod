<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Radio extends Component
{
    public $name;
    public $title;
    public $value;
    public $checked;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $title = "", $value = false , $checked)
    {
        //
        $this->name = $name;
        $this->title = $title ?? $name;
        $this->value = $value;
        $this->checked = $checked;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form.radio');
    }
}
