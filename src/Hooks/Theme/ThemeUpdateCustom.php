<?php

namespace RactStudio\FrameStudio\Hooks\Theme;

/**
 * Handles custom theme updates (private servers, APIs, SaaS updates).
 */
class ThemeUpdateCustom extends BaseThemeHook
{
    protected static string $eventName = 'framestudio/theme/custom_updated';

    /**
     * Register custom update hook.
     * Triggered manually by developer or custom updater.
     */
    public static function register(): void
    {
        add_action('framestudio/theme/custom_update', [static::class, 'handle'], 10, 2);
    }

    /**
     * Handle custom theme update.
     *
     * @param string $themeSlug
     * @param mixed $response
     */
    public static function handle(string $themeSlug, $response): void
    {
        // error_log('[FrameStudio] Custom theme update handled for ' . $themeSlug);

        static::dispatch([
            'slug' => $themeSlug,
            'response' => $response,
            'time' => time(),
        ]);
    }
}
