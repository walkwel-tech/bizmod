<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Select extends Component
{
    public $options;
    public $selected;
    public $title;
    public $name;
    public $id;
    public $hideLabel;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name= null, $options = [], $title = null, $selected = null, $hideLabel = false)
    {
        $this->name = $name ?? 'department_id';
        $this->options = $options;

        $this->title = $title ?? __('basic.inputs.department.selector');

        $this->id = str_replace(['[', ']', '.'], '', "selector-{$name}");

        $this->selected = $selected;

        $this->hideLabel = $hideLabel;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form.select');
    }
}
