<?php

namespace RactStudio\FrameStudio\Cli\Commands;

use Symfony\Component\Console\Command\Command as BaseCommand;

/**
 * Base command for all WP Frame Studio CLI commands.
 */
abstract class Command extends BaseCommand
{
    /**
     * The application instance.
     *
     * @var \RactStudio\FrameStudio\Foundation\Application
     */
    protected $app;

    /**
     * Create a new command instance.
     *
     * @param \RactStudio\FrameStudio\Foundation\Application $app
     */
    public function __construct($app = null)
    {
        parent::__construct();
        $this->app = $app;
    }

    /**
     * Get the application instance.
     *
     * @return \RactStudio\FrameStudio\Foundation\Application
     */
    protected function app()
    {
        return $this->app;
    }
}

