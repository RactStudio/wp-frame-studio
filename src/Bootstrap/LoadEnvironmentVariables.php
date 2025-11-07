<?php

namespace RactStudio\FrameStudio\Bootstrap;

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;
use RactStudio\FrameStudio\Foundation\Application;

/**
 * Loads variables from the `.env` file into the environment.
 */
class LoadEnvironmentVariables
{
    /**
     * Bootstrap the given application.
     *
     * @param Application $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $this->checkForSpecificEnvironmentFile($app);

        try {
            $dotenv = Dotenv::createImmutable($app->basePath());
            $dotenv->load();
        } catch (InvalidPathException $e) {
            // .env file is optional, so we'll silently continue if it doesn't exist
        }
    }

    /**
     * Detect if a custom environment file matching the APP_ENV exists.
     *
     * @param Application $app
     * @return void
     */
    protected function checkForSpecificEnvironmentFile(Application $app)
    {
        if (file_exists($app->basePath() . '/.env')) {
            return;
        }

        // Check for .env.{environment} file
        $environment = getenv('APP_ENV') ?: 'production';
        $envFile = $app->basePath() . '/.env.' . $environment;

        if (file_exists($envFile)) {
            if (!file_exists($app->basePath() . '/.env')) {
                copy($envFile, $app->basePath() . '/.env');
            }
        }
    }
}

