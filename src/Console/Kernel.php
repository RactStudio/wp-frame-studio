<?php

namespace RactStudio\FrameStudio\Console;

use RactStudio\FrameStudio\Foundation\Application;

class Kernel
{
    /**
     * The application instance.
     *
     * @var \RactStudio\FrameStudio\Foundation\Application
     */
    protected $app;

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Create a new console kernel instance.
     *
     * @param  \RactStudio\FrameStudio\Foundation\Application  $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Run the console application.
     *
     * @return int
     */
    public function handle($input, $output = null)
    {
        $console = new Application($this->app, $this->app->version());
        
        $this->commands(); // Register default commands

        // Register user defined commands
        // $console->add(new CommandClass());

        return $console->run($input, $output);
    }
    
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        // Load commands from routes/console.php or similar
    }
}
