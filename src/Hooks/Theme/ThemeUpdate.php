<?php

namespace FrameStudio\Hooks\Theme;

/**
 * Handles updates from WordPress repository.
 */
class ThemeUpdate extends BaseThemeHook
{
    protected static string $eventName = 'framestudio/theme/updated';

    /**
     * Register theme update hook.
     */
    public static function register(): void
    {
        add_action('upgrader_process_complete', [static::class, 'handle'], 10, 2);
    }

    /**
     * Called after theme update.
     *
     * @param \WP_Upgrader $upgrader
     * @param array $options
     */
    public static function handle($upgrader, array $options): void
    {
        if (empty($options['type']) || $options['type'] !== 'theme') {
            return;
        }

        if (isset($options['themes']) && is_array($options['themes'])) {
            foreach ($options['themes'] as $theme) {
                error_log('[FrameStudio] Theme updated: ' . $theme);
            }
        }

        static::dispatch([
            'type' => $options['type'] ?? 'unknown',
            'themes' => $options['themes'] ?? [],
            'time' => time(),
        ]);
    }
}
