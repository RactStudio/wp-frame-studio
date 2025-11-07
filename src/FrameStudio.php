<?php

namespace RactStudio\FrameStudio;

use RactStudio\FrameStudio\Foundation\Application;
use RactStudio\FrameStudio\Foundation\BootManager;
use RactStudio\FrameStudio\Foundation\Kernel;

/**
 * Main entry class for the FrameStudio Composer package.
 * 
 * This class provides static methods to bootstrap the framework
 * and access the application container.
 */
class FrameStudio
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected static $app;

    /**
     * Bootstrap the framework.
     *
     * @param string|null $basePath
     * @return Application
     */
    public static function bootstrap($basePath = null)
    {
        if (static::$app) {
            return static::$app;
        }

        // Create the application instance
        static::$app = new Application($basePath);

        // Create boot manager and bootstrap
        $bootManager = new BootManager(static::$app);
        $bootManager->bootstrap();

        // Create kernel and handle request
        $kernel = new Kernel(static::$app, $bootManager);
        $kernel->handle();

        return static::$app;
    }

    /**
     * Get the application instance.
     *
     * @return Application|null
     */
    public static function app()
    {
        return static::$app;
    }

    /**
     * Set the application instance.
     *
     * @param Application $app
     * @return void
     */
    public static function setApp(Application $app)
    {
        static::$app = $app;
    }
}
