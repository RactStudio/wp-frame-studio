<?php

namespace RactStudio\FrameStudio\Support\Facades;

/**
 * Facade for the Router service.
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

