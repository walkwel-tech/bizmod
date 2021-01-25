<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

class ButtonDelete extends Component
{
    public $model;
    public $routes;
    public $modelName;
    public $identifier;
    public $trashed;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model, $routeDestroy = null, $routeRestore = null, $routeDelete = null, $modelName = null, $identifier = null)
    {
        $this->trashed = method_exists($model, 'trashed') ? $model->trashed() : false;

        $this->model        = $model;
        $this->routes       = [
            'destroy' => $routeDestroy,
            'restore' => $routeRestore,
            'delete'  => $routeDelete,
        ];
        $this->modelName    = $modelName ?? 'Model';
        $this->identifier   = $identifier ?? $model->id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.ui.button-delete');
    }
}
