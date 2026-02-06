<?php

namespace RactStudio\FrameStudio\Foundation;

use RactStudio\FrameStudio\Container\Container;
use RactStudio\FrameStudio\Bootstrap\BootManager;

class Application extends Container
{
    /**
     * The base path for the application.
     *
     * @var string
     */
    protected $basePath;

    /**
     * The application version.
     *
     * @var string
     */
    const VERSION = '0.1.0';

    /**
     * Create a new infrastructure application instance.
     *
     * @param  string|null  $basePath
     * @return void
     */
    public function __construct($basePath = null)
    {
        if ($basePath) {
            $this->setBasePath($basePath);
        }

        $this->registerBaseBindings();
        $this->registerCoreContainerAliases();
    }

    /**
     * Set the base path for the application.
     *
     * @param  string  $basePath
     * @return $this
     */
    public function setBasePath($basePath)
    {
        $this->basePath = rtrim($basePath, '\/');
        return $this;
    }

    /**
     * Get the version number of the application.
     *
     * @return string
     */
    public function version()
    {
        return static::VERSION;
    }

    /**
     * Register the basic bindings into the container.
     *
     * @return void
     */
    protected function registerBaseBindings()
    {
        static::setInstance($this);

        $this->singleton('app', function ($app) {
            return $app;
        });

        $this->singleton(Container::class, function ($app) {
            return $app;
        });
    }

    /**
     * Register the core container aliases.
     *
     * @return void
     */
    protected function registerCoreContainerAliases()
    {
        // Aliases can be added here
    }

    /**
     * Boot the application.
     *
     * @return void
     */
    public function boot()
    {
        // Trigger boot sequence via BootManager or internally
        // In a real Laravel app, "booting" providers happens here.
    }
}
