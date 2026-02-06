<?php

namespace RactStudio\FrameStudio\Support;

use RactStudio\FrameStudio\Foundation\Application;

abstract class ServiceProvider
{
    /**
     * The application instance.
     *
     * @var \RactStudio\FrameStudio\Foundation\Application
     */
    protected $app;

    /**
     * Create a new service provider instance.
     *
     * @param  \RactStudio\FrameStudio\Foundation\Application  $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
