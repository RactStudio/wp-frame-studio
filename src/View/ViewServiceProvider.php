<?php

namespace RactStudio\FrameStudio\View;

use RactStudio\FrameStudio\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('view', function ($app) {
            // Default path, usually overwritable by config
            $path = $app['config']['view.paths'] ?? [];
            return new Factory($path, $app['config']['view.options'] ?? []);
        });
    }
}
