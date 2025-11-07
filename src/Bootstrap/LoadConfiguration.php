<?php

namespace RactStudio\FrameStudio\Bootstrap;

use Illuminate\Config\Repository;
use RactStudio\FrameStudio\Foundation\Application;

/**
 * Reads and merges configuration files from the user's `config/` directory.
 */
class LoadConfiguration
{
    /**
     * Bootstrap the given application.
     *
     * @param Application $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $items = [];

        // Load configuration files from config directory
        $configPath = $app->configPath();

        if (is_dir($configPath)) {
            $files = $this->getConfigurationFiles($app);

            foreach ($files as $key => $path) {
                $items[$key] = require $path;
            }
        }

        $app->instance('config', $config = new Repository($items));
    }

    /**
     * Get all of the configuration files for the application.
     *
     * @param Application $app
     * @return array
     */
    protected function getConfigurationFiles(Application $app)
    {
        $files = [];
        $configPath = $app->configPath();

        if (!is_dir($configPath)) {
            return $files;
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($configPath, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $files[basename($file->getRealPath(), '.php')] = $file->getRealPath();
            }
        }

        ksort($files, SORT_NATURAL);

        return $files;
    }
}

