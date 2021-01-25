<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PageHeader extends Component
{

    public $class;
    public $title;
    public $description;

    public $imageUrl;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = null, $description = null, $class = null, $imageUrl = null)
    {
        $this->title = $title ?? __('basic.profile.title');
        $this->description = $description ?? '';

        $this->class = $class ?? '';
        $this->imageUrl = $imageUrl;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.page-header');
    }
}
