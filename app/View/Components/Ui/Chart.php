<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

class Chart extends Component
{
    public $id;
    public $type;
    public $chartData;

    public $mode;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $type, $chartData, $mode = 'transparent')
    {
        //
        $this->id = $id;
        $this->type = $type;
        $this->chartData = $chartData;
        $this->mode = $mode;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.ui.chart');
    }
}
