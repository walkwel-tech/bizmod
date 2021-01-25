<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Input extends Component
{
    public $name;
    public $title;
    public $placeholder;
    public $value;
    public $hideLabel;

    public $type;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $title = '', $placeholder = null, $value = null, $type = 'text', $hideLabel = false)
    {
        $this->name = $name;
        $this->value = $value;

        $this->title = $title ?? $name;
        $this->placeholder = $placeholder ?? $this->title;

        $this->hideLabel = $hideLabel;

        $this->type = $type ?? 'text';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form.input');
    }
}
