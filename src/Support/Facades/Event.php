<?php

namespace RactStudio\FrameStudio\Support\Facades;

use RactStudio\FrameStudio\Foundation\Facade;

/**
 * @method static void listen(string|array $events, mixed $listener)
 * @method static bool hasListeners(string $eventName)
 * @method static array|null dispatch(string|object $event, mixed $payload = [])
 *
 * @see \RactStudio\FrameStudio\Events\Dispatcher
 */
class Event extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'events';
    }
}
