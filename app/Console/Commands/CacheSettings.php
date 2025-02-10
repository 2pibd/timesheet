<?php
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class CacheSettings extends Command
{
    protected $signature = 'settings:cache';
    protected $description = 'Cache settings from the database';

    public function handle()
    {
        Cache::forget('app_settings'); // Clear old cache
        $settings = DB::table('settings')->pluck('value', 'key')->toArray();
        Cache::forever('app_settings', $settings);

        $this->info('Settings cached successfully.');
    }
}
