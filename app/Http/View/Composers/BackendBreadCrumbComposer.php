<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Carbon\Carbon;
use App\Helpers\NavigationItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class BackendBreadCrumbComposer
{
    private $breadcrumbs;
    private $currentcrumb;

    /**
     * Create a new navigation composer.
     *
     * @return void
     */
    public function __construct()
    {
        $this->breadcrumbs = collect();
        $this->breadcrumbs->push(
            new NavigationItem('', route('admin.home'), 'fa fa-home')
        );

        $this->populateBreadCrumbs();
    }

    public function populateBreadCrumbs()
    {
        $routeName = Route::currentRouteName();
        $routeParts = collect(explode('.', $routeName));

        $partTemp = collect();
        $currentPartName = $routeParts->pop();

        if ($currentPartName == 'index') {
            $currentPartName = $tempPart = $routeParts->pop();
            $routeParts->push($tempPart);
        }

        $finalParts = $routeParts->map(function ($part) use (&$partTemp) {
            $partTemp->push($part);

            return $partTemp->implode('.') . '.index';
        });

        $breadcrumbs = &$this->breadcrumbs;
        $finalParts->each(function ($routePart) use (&$breadcrumbs) {

            $partName = NavigationItem::getPartName($routePart);
            try {
                if (Route::has($routePart)) {
                    $breadcrumbs->push(new NavigationItem($partName, ['type' => 'laravel', 'link' => $routePart]));
                } elseif (Route::has($routePart . '.index')) {
                    $breadcrumbs->push(new NavigationItem($partName, ['type' => 'laravel', 'link' => $routePart . '.index']));
                }
            } catch(UrlGenerationException $ex) {

            }
        });

        $this->currentcrumb = $currentCrumb = new NavigationItem(NavigationItem::getPartName($currentPartName), ['type' => 'direct', 'link' => url()->current()]);

        $this->breadcrumbs = $this->breadcrumbs->filter(function ($crumb) use ($currentCrumb) {
            return $crumb && ($crumb instanceof NavigationItem) && $crumb->getRoute() !== $currentCrumb->getRoute();
        });
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('breadcrumbs', $this->breadcrumbs);
        $view->with('currentcrumb', $this->currentcrumb);
    }
}
