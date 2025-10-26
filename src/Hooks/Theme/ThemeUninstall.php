<?php

namespace RactStudio\FrameStudio\Hooks\Theme;

/**
 * Handles theme uninstall or removal events.
 * WordPress does not provide native uninstall for themes, so this is custom.
 */
class ThemeUninstall extends BaseThemeHook
{
    protected static string $eventName = 'framestudio/theme/uninstalled';

    /**
     * Register uninstall hook (custom logic).
     */
    public static function register(): void
    {
        // Developers can call this manually when theme is removed
        add_action(static::$eventName, [static::class, 'handle']);
    }

    /**
     * Called on theme uninstall/removal.
     */
    public static function handle(): void
    {
        // error_log('[FrameStudio] Theme uninstalled.');

        static::dispatch([
            'theme' => wp_get_theme()->get('Name'),
            'time' => time(),
        ]);
    }
}
