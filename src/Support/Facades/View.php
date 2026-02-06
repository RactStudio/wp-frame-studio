<?php

namespace RactStudio\FrameStudio\Support\Facades;

use RactStudio\FrameStudio\Foundation\Facade;

/**
 * @method static string make(string $view, array $data = [])
 * @method static string render(string $view, array $data = [])
 *
 * @see \RactStudio\FrameStudio\View\Factory
 */
class View extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'view';
    }
}
