<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $type;
    public $dismissible;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type = 'success', $dismissible = true)
    {
        $this->type = $type ?? 'success';
        $this->dismissible = $dismissible == "true";
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.alert');
    }
}
