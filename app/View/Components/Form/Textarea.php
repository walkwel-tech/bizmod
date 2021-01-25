<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Textarea extends Component
{
    public $name;
    public $title;
    public $placeholder;
    public $value;
    public $elementId;

    public $type;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $title = '', $placeholder = null, $value = null, $type = 'text')
    {
        $this->name = $name;
        $this->value = $value;

        $this->title = $title ?? $name;
        $this->placeholder = $placeholder ?? $this->title;


        $this->elementId = make_non_unique_slug($name);

        $this->type = $type ?? 'text';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form.textarea');
    }
}
