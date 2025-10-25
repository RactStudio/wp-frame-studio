<?php

namespace FrameStudio\Hooks\Plugin;

/**
 * Handles plugin uninstall events.
 */
class PluginUninstall extends BasePluginHook
{
    protected static string $eventName = 'framestudio/plugin/uninstalled';

    /**
     * Registers the uninstall hook.
     *
     * @param string $mainFile
     */
    public static function register(string $mainFile): void
    {
        \register_uninstall_hook($mainFile, [static::class, 'handle']);
    }

    /**
     * Called when the plugin is uninstalled (removed from system).
     */
    public static function handle(): void
    {
        error_log('[FrameStudio] Plugin uninstalled.');

        static::dispatch([
            'time' => time(),
            'source' => static::class,
        ]);
    }
}
