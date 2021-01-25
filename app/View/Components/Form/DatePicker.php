<?php

namespace App\View\Components\Form;

use Carbon\Carbon;
use Illuminate\View\Component;

class DatePicker extends Component
{
    public $name;
    public $title;
    public $placeholder;
    public $value;
    public $hideLabel;
    public $singlePicker;
    public $format;
    public $type;

    public $fieldType;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $title = '', $placeholder = null, $value = null, $hideLabel = false, $singlePicker = true, $format = 'Y-m-d', $type="only-date")
    {
        $this->name = $name;
        if($value instanceof Carbon) {
            $this->value = $value->format($format);
        } else {
            $this->value = $value;
        }

        $this->format = $format;

        $this->title = $title ?? $name;
        $this->placeholder = $placeholder ?? $this->title;

        $this->hideLabel = $hideLabel;
        $this->singlePicker = $singlePicker;

        $this->type = $type;
        $this->fieldType = 'text';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form.date-picker');
    }
}
