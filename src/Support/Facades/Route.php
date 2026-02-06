<?php

namespace RactStudio\FrameStudio\Support\Facades;

use RactStudio\FrameStudio\Foundation\Facade;

/**
 * @method static void get(string $uri, mixed $action)
 * @method static void post(string $uri, mixed $action)
 * @method static \RactStudio\FrameStudio\Http\Response dispatch(\RactStudio\FrameStudio\Http\Request $request)
 *
 * @see \RactStudio\FrameStudio\Http\Router
 */
class Route extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'router';
    }
}
