<?php

namespace App\Providers;

use App\Http\View\Composers\BackendBreadCrumbComposer;
use App\Http\View\Composers\BackendNavigationComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class NavigationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer([
                'layouts.navbars.sidebar',
            ],
            BackendNavigationComposer::class
        );

        View::composer([
                'layouts.navbar.breadcrumb',
            ],
            BackendBreadCrumbComposer::class
        );
    }
}
