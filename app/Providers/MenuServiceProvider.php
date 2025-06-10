<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\SiteSettings;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Ambil menu
        $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenu.json'));
        $verticalMenuData = json_decode($verticalMenuJson);

        // Ambil setting
        $setting = SiteSettings::first();

        // Bagikan ke semua view
        view()->share('menuData', [$verticalMenuData]);
        view()->share('setting', $setting);
    }
}