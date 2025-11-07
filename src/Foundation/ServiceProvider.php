<?php

namespace RactStudio\FrameStudio\Foundation;

use RactStudio\FrameStudio\Foundation\Application;

/**
 * Abstract base class for all Service Providers.
 * 
 * Service Providers are the primary way to register services into the
 * application container and connect them to WordPress hooks.
 */
abstract class ServiceProvider
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * The paths that should be published.
     *
     * @var array
     */
    public static $publishes = [];

    /**
     * The paths that should be published by groups.
     *
     * @var array
     */
    public static $publishGroups = [];

    /**
     * Create a new service provider instance.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Register any application services.
     * 
     * This method should only bind services to the container.
     * DO NOT register WordPress hooks here.
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
     * This method is called after all service providers have been registered.
     * Use this method to register WordPress hooks, filters, and actions.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Get the events that trigger this service provider to register.
     *
     * @return array
     */
    public function when()
    {
        return [];
    }

    /**
     * Merge the given configuration with the existing configuration.
     *
     * @param string $path
     * @param string $key
     * @return void
     */
    protected function mergeConfigFrom($path, $key)
    {
        $config = $this->app['config']->get($key, []);

        $this->app['config']->set($key, array_merge(require $path, $config));
    }

    /**
     * Load the given routes file if routes are not already cached.
     *
     * @param string $path
     * @return void
     */
    protected function loadRoutesFrom($path)
    {
        if (!$this->app->routesAreCached()) {
            require $path;
        }
    }

    /**
     * Register paths to be published by the publish command.
     *
     * @param array $paths
     * @param mixed $groups
     * @return void
     */
    protected function publishes(array $paths, $groups = null)
    {
        $this->ensurePublishArrayInitialized();

        static::$publishes = array_merge(static::$publishes, $paths);

        if (!is_null($groups)) {
            foreach ((array) $groups as $group) {
                if (!isset(static::$publishGroups[$group])) {
                    static::$publishGroups[$group] = [];
                }

                static::$publishGroups[$group] = array_merge(
                    static::$publishGroups[$group],
                    $paths
                );
            }
        }
    }

    /**
     * Ensure the publish array has been initialized.
     *
     * @return void
     */
    protected function ensurePublishArrayInitialized()
    {
        if (!isset(static::$publishes)) {
            static::$publishes = [];
        }

        if (!isset(static::$publishGroups)) {
            static::$publishGroups = [];
        }
    }
}

