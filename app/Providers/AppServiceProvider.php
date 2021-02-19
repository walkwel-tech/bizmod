<?php

namespace App\Providers;


use Illuminate\Pagination\Paginator;

use App\Contracts\Repository\DivisionRepositoryContract;
use App\Contracts\Repository\LocationsRepositoryContract;
use App\Contracts\Repository\PermissionRepositoryContract;
use App\Contracts\Repository\PhaseRepositoryContract;
use App\Contracts\Repository\UserRepositoryContract;
use App\Repositories\DivisionRepository;
use App\Repositories\LocationsRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\PhaseRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PermissionRepositoryContract::class, function ($app) {
            return new PermissionRepository;
        });

        $this->app->singleton(UserRepositoryContract::class, function ($app) {
            return new UserRepository;
        });

        $this->app->singleton(LocationsRepositoryContract::class, function ($app) {
            return new LocationsRepository;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
