<?php

namespace RactStudio\FrameStudio\Support\Facades;

use RactStudio\FrameStudio\Foundation\Facade;

/**
 * @method static \RactStudio\FrameStudio\Database\Query\Builder table(string $table)
 * @method static mixed select(string $query, array $bindings = [])
 *
 * @see \RactStudio\FrameStudio\Database\Connection
 */
class DB extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'db';
    }
}
