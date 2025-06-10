<?php

namespace App\Providers;

use App\Models\Kelompok;
use App\Models\SiteSettings;
use App\Repositories\BukuRepository\BukuRepository;
use App\Repositories\BukuRepository\BukuRepositoryInterface;
use App\Repositories\InstansiRepository\InstansiRepository;
use App\Repositories\InstansiRepository\InstansiRepositoryInterface;
use App\Repositories\jenisRepository\JenisRepository;
use App\Repositories\JenisRepository\JenisRepositoryInterface;
use App\Repositories\KelompokRepository\KelompokRepository;
use App\Repositories\KelompokRepository\KelompokRepositoryInterface;
use App\Repositories\PermissionRepository\PermissionRepository;
use App\Repositories\PermissionRepository\PermissionRepositoryInterface;
use App\Repositories\RoleRepository\RoleRepository;
use App\Repositories\RoleRepository\RoleRepositoryInterface;
use App\Repositories\SubKelompokRepository\SubKelompokRepository;
use App\Repositories\SubKelompokRepository\SubKelompokRepositoryInterface;
use App\Repositories\UserRepository\UserRepository;
use App\Repositories\UserRepository\UserRepositoryInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
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
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(InstansiRepositoryInterface::class, InstansiRepository::class);
        $this->app->bind(JenisRepositoryInterface::class, JenisRepository::class);
        $this->app->bind(KelompokRepositoryInterface::class, KelompokRepository::class);
        $this->app->bind(SubKelompokRepositoryInterface::class, SubKelompokRepository::class);
        $this->app->bind(BukuRepositoryInterface::class, BukuRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
