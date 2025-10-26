<?php

namespace RactStudio\FrameStudio\Hooks\Plugin;

/**
 * Handles plugin deactivation events.
 */
class PluginDeactivate extends BasePluginHook
{
    protected static string $eventName = 'framestudio/plugin/deactivated';

    /**
     * Registers the deactivation hook.
     *
     * @param string $mainFile
     */
    public static function register(string $mainFile): void
    {
        \register_deactivation_hook($mainFile, [static::class, 'handle']);
    }

    /**
     * Called when the plugin is deactivated.
     */
    public static function handle(): void
    {
        // error_log('[FrameStudio] Plugin deactivated.');

        static::dispatch([
            'time' => time(),
            'source' => static::class,
        ]);
    }
}
