<?php

namespace RactStudio\FrameStudio\Hooks\Theme;

/**
 * Base class for all theme hook handlers.
 * Provides shared logic for event dispatching and developer callbacks.
 */
abstract class BaseThemeHook
{
    /**
     * Event name for do_action / add_action.
     * Child classes must override.
     *
     * @var string
     */
    protected static string $eventName = '';

    /**
     * Attach a developer callback to this hook.
     *
     * @param callable $callback
     * @param int $priority
     * @param int $args
     */
    public static function on(callable $callback, int $priority = 10, int $args = 1): void
    {
        add_action(static::$eventName, $callback, $priority, $args);
    }

    /**
     * Dispatch the hook with optional payload.
     *
     * @param mixed $payload
     */
    protected static function dispatch($payload = null): void
    {
        do_action(static::$eventName, $payload);
    }
}
