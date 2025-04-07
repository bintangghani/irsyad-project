<?php

namespace App\Providers;

use App\Repositories\PermissionRepository\PermissionRepository;
use App\Repositories\PermissionRepository\PermissionRepositoryInterface;
use App\Repositories\RoleRepository\RoleRepository;
use App\Repositories\RoleRepository\RoleRepositoryInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Paginator::useBootstrap();
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
