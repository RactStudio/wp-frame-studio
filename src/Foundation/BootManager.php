<?php

namespace RactStudio\FrameStudio\Foundation;

use RactStudio\FrameStudio\Foundation\Application;
use RactStudio\FrameStudio\Bootstrap\LoadEnvironmentVariables;
use RactStudio\FrameStudio\Bootstrap\LoadConfiguration;
use RactStudio\FrameStudio\Bootstrap\RegisterCoreFacades;
use RactStudio\FrameStudio\Bootstrap\StartSession;

/**
 * Orchestrates the framework initialization lifecycle.
 * 
 * This class loads all core services and providers in the correct order,
 * ensuring the framework is properly bootstrapped before WordPress hooks are registered.
 */
class BootManager
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * The bootstrap classes for the application.
     *
     * @var array
     */
    protected $bootstrappers = [
        LoadEnvironmentVariables::class,
        LoadConfiguration::class,
        RegisterCoreFacades::class,
        StartSession::class,
    ];

    /**
     * Create a new boot manager instance.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Bootstrap the application.
     *
     * @return void
     */
    public function bootstrap()
    {
        if (!$this->app->hasBeenBootstrapped()) {
            $this->app->bootstrapWith($this->bootstrappers);
        }
    }
}

