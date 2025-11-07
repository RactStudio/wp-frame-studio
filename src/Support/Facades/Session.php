<?php

namespace RactStudio\FrameStudio\Support\Facades;

/**
 * Facade for the Session service.
 */
class Session extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'session';
    }
}

