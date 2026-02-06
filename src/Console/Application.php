<?php

namespace RactStudio\FrameStudio\Console;

use Symfony\Component\Console\Application as SymfonyApplication;
use RactStudio\FrameStudio\Foundation\Application as CoreApplication;

class Application extends SymfonyApplication
{
    /**
     * The Frame Studio Application instance.
     *
     * @var \RactStudio\FrameStudio\Foundation\Application
     */
    protected $laravel;

    /**
     * Create a new Artisan console application.
     *
     * @param  \RactStudio\FrameStudio\Foundation\Application  $laravel
     * @param  string  $version
     * @return void
     */
    public function __construct(CoreApplication $laravel, $version)
    {
        parent::__construct('Frame Studio', $version);

        $this->laravel = $laravel;
    }
}
