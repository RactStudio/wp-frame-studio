<?php

namespace RactStudio\FrameStudio\Hooks\Theme;

/**
 * Handles theme activation events.
 */
class ThemeActivate extends BaseThemeHook
{
    protected static string $eventName = 'framestudio/theme/activated';

    /**
     * Register activation hook.
     */
    public static function register(): void
    {
        add_action('after_switch_theme', [static::class, 'handle']);
    }

    /**
     * Called after the theme is activated.
     */
    public static function handle(): void
    {
        error_log('[FrameStudio] Theme activated.');

        static::dispatch([
            'theme' => wp_get_theme()->get('Name'),
            'time' => time(),
        ]);
    }
}
