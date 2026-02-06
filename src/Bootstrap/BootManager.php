<?php

namespace RactStudio\FrameStudio\Bootstrap;

use RactStudio\FrameStudio\Foundation\Application;

class BootManager
{
    /**
     * The application instance.
     *
     * @var \RactStudio\FrameStudio\Foundation\Application
     */
    protected $app;

    /**
     * Create a new boot manager instance.
     *
     * @param  \RactStudio\FrameStudio\Foundation\Application  $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Boot the framework.
     *
     * @return void
     */
    public function boot()
    {
        // 1. Load Configuration
        // 2. Register Service Providers
        // Default Core Providers
        (new \RactStudio\FrameStudio\View\ViewServiceProvider($this->app))->register();

        // 3. Boot Service Providers
        
        $this->app->boot();
    }
}
