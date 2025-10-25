<?php

namespace FrameStudio\Hooks\Plugin;

/**
 * Base class for all plugin hook handlers.
 * Provides shared logic for event dispatching and callback binding.
 */
abstract class BasePluginHook
{
    /**
     * The event name used for do_action / add_action.
     * Must be overridden by each child class.
     *
     * @var string
     */
    protected static string $eventName = '';

    /**
     * Allow developers to attach custom callbacks to this hook.
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
     * Dispatch the hook event with an optional payload.
     *
     * @param mixed $payload
     */
    protected static function dispatch($payload = null): void
    {
        do_action(static::$eventName, $payload);
    }
}
