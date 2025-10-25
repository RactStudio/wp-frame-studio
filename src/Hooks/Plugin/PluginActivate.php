<?php

namespace FrameStudio\Hooks\Plugin;

/**
 * Handles plugin activation events.
 */
class PluginActivate extends BasePluginHook
{
    protected static string $eventName = 'framestudio/plugin/activated';

    /**
     * Registers the activation hook.
     *
     * @param string $mainFile
     */
    public static function register(string $mainFile): void
    {
        \register_activation_hook($mainFile, [static::class, 'handle']);
    }

    /**
     * Called when the plugin is activated.
     */
    public static function handle(): void
    {
        error_log('[FrameStudio] Plugin activated.');

        static::dispatch([
            'time' => time(),
            'source' => static::class,
        ]);
    }
}
