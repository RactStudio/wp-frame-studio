<?php

namespace RactStudio\FrameStudio\Support\Facades;

use RactStudio\FrameStudio\Foundation\Facade;

/**
 * @method static bool allows(string $capability, mixed $arguments = [])
 * @method static bool denies(string $capability, mixed $arguments = [])
 *
 * @see \RactStudio\FrameStudio\Auth\Gate
 */
class Gate extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        // For simplicity, we can bind a Gate manager or just use a closure in binding
        // But let's assume we bind 'gate' to a class wrapper around current_user_can
        return 'gate';
    }
}
