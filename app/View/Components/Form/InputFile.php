<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class InputFile extends Component
{
    public $name;
    public $label;
    public $title;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name = null, $label = null, $title = null)
    {
        $this->name = $name ?? 'avatar';
        $this->label = $label ?? __('basic.inputs.avatar');
        $this->title = $title ?? 'Avatar';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form.input-file');
    }
}
