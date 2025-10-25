<?php

namespace FrameStudio\Hooks\Theme;

/**
 * Handles theme deactivation events.
 */
class ThemeDeactivate extends BaseThemeHook
{
    protected static string $eventName = 'framestudio/theme/deactivated';

    /**
     * Register deactivation hook.
     */
    public static function register(): void
    {
        add_action('switch_theme', [static::class, 'handle'], 10, 2);
    }

    /**
     * Called when theme is switched/deactivated.
     *
     * @param string $newName
     * @param string $oldName
     */
    public static function handle(string $newName = '', string $oldName = ''): void
    {
        error_log('[FrameStudio] Theme deactivated: ' . $oldName);

        static::dispatch([
            'old_theme' => $oldName,
            'new_theme' => $newName,
            'time' => time(),
        ]);
    }
}
