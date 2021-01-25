<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

class ButtonIcon extends Component
{
    public $icon;
    public $text;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($icon, $text)
    {
        //
        $this->icon = $icon;
        $this->text = $text;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.ui.button-icon');
    }
}
