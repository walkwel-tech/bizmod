<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StatsCard extends Component
{

    public $nature;
    public $direction;

    public $title;
    public $stats;

    public $value;
    public $text;

    public $icon;
    public $iconBg;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = null, $stats = null, $value = null, $text = null, $direction = null, $nature = null, $icon = 'fas fa-chart-bar', $iconBg = 'danger')
    {
        $this->stats = $stats ?? '';
        $this->value = $value ?? '';

        $this->title = $title ?? __('basic.stats.title');
        $this->text = $text ?? __('basic.stats.text');

        $this->nature = $nature ?? $this->checkNatureBasedOnValue();

        $this->icon = $icon ?? 'fas fa-chart-bar';
        $this->iconBg = $iconBg ?? 'danger';

        $this->direction = $direction ?? $this->checkDirectionBasedOnValue();
    }

    public function checkNatureBasedOnValue()
    {
        return ($this->value > 0) ? 'success' : 'warning';
    }

    public function checkDirectionBasedOnValue()
    {
        return ($this->value > 0) ? 'up' : 'down';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.stats-card');
    }
}
