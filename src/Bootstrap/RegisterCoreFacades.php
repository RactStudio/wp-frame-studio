<?php

namespace RactStudio\FrameStudio\Bootstrap;

use RactStudio\FrameStudio\Foundation\Application;
use RactStudio\FrameStudio\Support\Facades\Facade;

/**
 * Binds Facade accessors to their concrete Service Container implementations.
 */
class RegisterCoreFacades
{
    /**
     * Bootstrap the given application.
     *
     * @param Application $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        Facade::setFacadeApplication($app);

        // Alias the Application instance in the container
        $app->alias('app', Application::class);
    }
}

