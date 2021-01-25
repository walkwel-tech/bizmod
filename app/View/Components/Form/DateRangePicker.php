<?php

namespace App\View\Components\Form;

use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\View\Component;

class DateRangePicker extends Component
{
    public $name;
    public $title;
    public $id;
    public $placeholder;
    public $valueStart;
    public $valueEnd;
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
    public function __construct($name, $title = '', $placeholder = null, $valueStart = null, $valueEnd = null, $hideLabel = false, $format = 'Y-m-d', $type="only-date")
    {

        $this->name = $name;
        if($valueStart instanceof Carbon) {
            $this->valueStart = $valueStart->format($format);
        } else {
            $this->valueStart = $valueStart;
        }

        $this->id = [
            'start' => Str::kebab($this->name) . '-start',
            'end' => Str::kebab($this->name) . '-end',
        ];

        if($valueEnd instanceof Carbon) {
            $this->valueEnd = $valueEnd->format($format);
        } else {
            $this->valueEnd = $valueEnd;
        }

        $this->format = $format;

        $this->title = $title ?? $name;
        $this->placeholder = $placeholder ?? $this->title;

        $this->hideLabel = $hideLabel;

        $this->type = $this->finalizeType($type);
        $this->fieldType = 'text';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form.date-range-picker');
    }

    protected function finalizeType ($type)
    {
        $types = [
            'only-date',
            'with-time'
        ];

        return (in_array($type, $types))
            ? $type
            : $types[0];
    }
}
