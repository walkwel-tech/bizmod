<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Carbon\Carbon;
use App\Helpers\NavigationItem;
use Illuminate\Support\Str;

class BackendNavigationComposer
{
    /**
     * Create a new navigation composer.
     *
     * @return void
     */
    public function __construct()
    {
        $this->backendRoutes = collect();
        $this->backendRoutes->push(
            new NavigationItem(__('Dashboard'), route('admin.home'), 'ni ni-tv-2', 'section')
        );
        $this->createModelRoutes('Roles', 'role', 'fa fa-allergies', false);

        $this->createModelRoutes('Users', 'user', 'fa fa-users', true);

        $this->createModelRoutes('Pages', 'page', 'fa fa-barcode', true);

        $this->createModelRoutes('Categories', 'category', 'fa fa-list-alt', true);

        $this->createModelRoutes('Services', 'service', 'fa fa-barcode', true);

        $this->createModelRoutes('Steps', 'step', 'fa fa-barcode', true);

        $this->createModelRoutes('Fields', 'field', 'fa fa-barcode', true);

        $this->createModelRoutes('Service Order', 'serviceorder', 'fa fa-barcode', true);
    }

    public function createModelRoutes($modelTitle, $modelRouteKey, $icon = null, $softDeletes = true, $creations = true)
    {
        $key = Str::plural($modelRouteKey);
        $user = auth()->user();

        if ($user->can("backend.{$key}.read")) {
            $modelRoutes = new NavigationItem('' . Str::plural($modelTitle),  route("admin.{$modelRouteKey}.index"), null);
            $modelRoutes->setIconClass($icon);

            $modelRoutes->addChild('List ' . Str::plural($modelTitle), route("admin.{$modelRouteKey}.index"));

            if ($creations && $user->can("backend.{$key}.create")) {
                $modelRoutes->addChild('Create ' . Str::singular($modelTitle), route("admin.{$modelRouteKey}.create"));
            }

            if ($softDeletes && $user->can("backend.{$key}.delete")) {
                $modelRoutes->addChild('Trashed ' . Str::plural($modelTitle), route("admin.{$modelRouteKey}.trashed"));
            }


            // // Test Routes
            // $test= new NavigationItem('Test', '#', null, 'child');
            // $test->setBadgeCount(30);
            // $test->addChild('Ola', '#');
            // $test->addChild('Ola Ola', '#');

            // $t2 = new NavigationItem('Test 2', '#', null, 'child');
            // $t2->setBadgeCount(34);
            // $t2->addChild("DS", route('admin.events.create'));
            // $test->appendChild($t2);
            // $events->appendChild($test);

            $this->backendRoutes
                ->push(
                    $modelRoutes
                );
        }
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('backendRoutes', $this->backendRoutes);
    }
}
