<?php

namespace RactStudio\FrameStudio\Cli;

use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Command\Command;

/**
 * Integrates Symfony Console to run developer commands via the `frame` executable.
 */
class Console extends ConsoleApplication
{
    /**
     * The application instance.
     *
     * @var \RactStudio\FrameStudio\Foundation\Application
     */
    protected $app;

    /**
     * Create a new console instance.
     *
     * @param \RactStudio\FrameStudio\Foundation\Application $app
     */
    public function __construct($app)
    {
        parent::__construct('WP Frame Studio', '0.1.0');
        $this->app = $app;
    }

    /**
     * Register a command with the console.
     *
     * @param Command|string $command
     * @return Command
     */
    public function registerCommand($command)
    {
        if (is_string($command)) {
            $command = $this->app->make($command);
        }

        return $this->add($command);
    }

    /**
     * Register multiple commands.
     *
     * @param array $commands
     * @return void
     */
    public function registerCommands(array $commands)
    {
        foreach ($commands as $command) {
            $this->registerCommand($command);
        }
    }
}

