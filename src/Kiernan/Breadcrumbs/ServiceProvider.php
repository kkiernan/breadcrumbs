<?php

namespace Kiernan\Breadcrumbs;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Kiernan\Breadcrumbs\Generator;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('breadcrumbs', function () {
            return new Generator();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewsFrom(__DIR__ . '/../../views', 'kkiernan');

        $this->publishes([
            __DIR__ . '/../../views' => base_path('resources/views/vendor/kkiernan')
        ], 'kkiernan');
    }
}
