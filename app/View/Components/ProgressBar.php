<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProgressBar extends Component
{
    public $value;
    public $bg;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($value = 50, $bg = 'danger')
    {
        $this->value = $value;
        $this->bg = $bg;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.progress-bar');
    }
}
