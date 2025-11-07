<?php

namespace RactStudio\FrameStudio\Foundation;

use RactStudio\FrameStudio\Foundation\Application;
use RactStudio\FrameStudio\Foundation\BootManager;

/**
 * The entry point for running the application after bootstrap.
 * 
 * This class handles the request lifecycle and coordinates
 * between the framework and WordPress.
 */
class Kernel
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * The bootstrap manager instance.
     *
     * @var BootManager
     */
    protected $bootManager;

    /**
     * Create a new kernel instance.
     *
     * @param Application $app
     * @param BootManager $bootManager
     */
    public function __construct(Application $app, BootManager $bootManager)
    {
        $this->app = $app;
        $this->bootManager = $bootManager;
    }

    /**
     * Handle the incoming request.
     *
     * @return void
     */
    public function handle()
    {
        $this->bootManager->bootstrap();
        
        // Boot all registered service providers
        $this->app->boot();
    }

    /**
     * Terminate the request.
     *
     * @return void
     */
    public function terminate()
    {
        // Perform any cleanup or finalization
    }
}

