<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class InputAlternative extends Component
{
    public $name;
    public $placeholder;
    public $value;
    public $type;
    public $icon;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $placeholder = null, $value = null, $type = 'text', $icon = null)
    {
        $this->name = $name;
        $this->value = $value;

        $this->placeholder = $placeholder ?? $this->name;

        $this->type = $type ?? 'text';
        $this->icon = $icon ?? 'ni-ruler-pencil';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form.input-alternative');
    }
}
