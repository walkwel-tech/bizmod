<?php

namespace App\Providers;

use App\Observers\ServiceObserver;
use App\Observers\CategoryObserver;
use App\Service;
use App\Category;

use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Service::observe(ServiceObserver::class);
        Category::observe(CategoryObserver::class);
    }
}
