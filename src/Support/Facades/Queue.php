<?php

namespace RactStudio\FrameStudio\Support\Facades;

/**
 * Facade for the Queue service.
 */
class Queue extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'queue';
    }
}

