<?php

namespace RactStudio\FrameStudio\Support\Facades;

/**
 * Facade for the Cache service.
 */
class Cache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cache';
    }
}

