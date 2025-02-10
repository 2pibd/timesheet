<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;
class SettingsServiceProvider extends ServiceProvider
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



// Cache settings
        $settings = Cache::rememberForever('app_settings', function () {
            return DB::table('settings')->pluck('value', 'key')->toArray();
        });

// Load settings into Laravel config
        foreach ($settings as $key => $value) {
            Config::set("webconfig.{$key}", $value);
        }

    }
}
