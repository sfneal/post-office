<?php

namespace Sfneal\PostOffice\Providers;

use Illuminate\Support\ServiceProvider;

class PostOfficeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any Tracking services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config file
        $this->publishes([
            __DIR__.'/../../config/post-office.php' => config_path('post-office.php'),
        ], 'config');

        // Load Views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'post-office');

        // Publish Views
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/post-office'),
        ], 'views');
    }

    /**
     * Register any Tracking services.
     *
     * @return void
     */
    public function register()
    {
        // Load config file
        $this->mergeConfigFrom(__DIR__.'/../../config/post-office.php', 'post-office');
    }
}
